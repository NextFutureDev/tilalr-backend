<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpCode;
use App\Services\SmsService;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AuthController extends Controller
{
    protected $sms;
    protected $otpService;

    public function __construct(SmsService $sms, OtpService $otpService)
    {
        $this->sms = $sms;
        $this->otpService = $otpService;
    }

    /**
     * Register a new user (sends OTP; requires verification)
     */
    public function register(Request $request)
    {
        // Require phone at registration and enforce unique email if provided
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            // Email is optional - must be valid email if provided, unique if not empty
            'email' => 'nullable|email:rfc,dns|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.email' => 'Please enter a valid email address or leave it empty to register with phone only.',
            'email.unique' => 'This email is already registered. Please login or use a different email.',
            'phone.unique' => 'This phone number is already registered. Please login or use a different phone.',
        ]);

        // Create the user with defensive error handling for duplicate constraints
        try {
            // Ensure email is null if empty (don't send empty strings)
            $email = $request->email && trim($request->email) ? trim($request->email) : null;
            
            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'is_admin' => false,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Log a warning and return a friendly validation-like response
            \Illuminate\Support\Facades\Log::warning('Auth register: DB constraint', ['error' => $e->getMessage()]);

            // Detect common unique constraint names (MySQL error message contains index name)
            $msg = $e->getMessage();
            if (str_contains($msg, 'users_email_unique') || str_contains($msg, 'Duplicate entry') && str_contains($msg, 'for key')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email already exists. Please use a different email or login.',
                    'errors' => [ 'email' => ['Email already exists.'] ]
                ], 422);
            }

            if (str_contains($msg, 'users_phone_unique')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number already registered. Please login or use a different phone.',
                    'errors' => [ 'phone' => ['Phone number already registered.'] ]
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to create user. Please try again later.'
            ], 500);
        }

        // Send OTP for registration verification using OtpService
        try {
            $result = $this->otpService->send($user->phone, 'register');
        } catch (\Throwable $e) {
            // Log the error and return a friendly response instead of letting a 500 bubble up
            \Illuminate\Support\Facades\Log::error('Auth register: OTP send failed', ['err' => $e->getMessage()]);
            return response()->json([
                'success' => true,
                'user' => $user,
                'message' => 'User created but OTP could not be sent. Please contact support or try again later.',
                'requires_otp' => true,
                'otp_sent' => false,
            ], 201);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
            'message' => 'OTP sent to phone. Please verify to complete registration.',
            'requires_otp' => true,
            'otp_sent' => $result['success'],
            // Include fixed OTP in dev mode for convenience
            'dev_otp' => $this->otpService->isFixedMode() ? $result['code'] : null,
        ], 201);
    }

    /**
     * Check if an email is already registered (public)
     */
    public function emailExists(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($request->email));
        $exists = \App\Models\User::whereRaw('LOWER(email) = ?', [$email])->exists();

        return response()->json(['exists' => (bool) $exists]);
    }

    /**
     * Login user - Step 1: Validate credentials and send OTP
     */
    public function login(Request $request)
    {
        try {
            // Set locale from Accept-Language header (supports 'ar' and 'en')
            $acceptLang = $request->header('Accept-Language');
            if ($acceptLang) {
                $lang = strtolower(substr($acceptLang, 0, 2));
                if (in_array($lang, ['ar', 'en'])) {
                    app()->setLocale($lang);
                }
            }

            // Allow login by phone (preferred) or email as a fallback
            $request->validate([
                'phone' => 'nullable|string',
                'email' => 'nullable|email',
                'password' => 'required',
            ]);

            $user = null;
            $credentialKey = null;
            
            if ($request->filled('phone')) {
                $user = User::where('phone', $request->phone)->first();
                $credentialKey = 'phone';
            } elseif ($request->filled('email')) {
                $user = User::where('email', $request->email)->first();
                $credentialKey = 'email';
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('auth.phone_or_email_required'),
                    'errors' => [
                        'phone' => [ __('auth.phone_or_email_required') ]
                    ]
                ], 422);
            }

            // Use a single generic error response to avoid user enumeration (privacy)
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => __('auth.invalid_credentials'),
                ], 401);
            }

            // If admin, issue token immediately (do not require OTP for admin panel)
            if ($user->is_admin) {
                $token = $user->createToken('auth-token')->plainTextToken;
                
                $user->load('roles.permissions');
                $permissions = $user->roles->flatMap(fn($role) => $role->permissions->pluck('name'))->unique()->values();

                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'roles' => $user->roles->pluck('name'),
                    'permissions' => $permissions,
                    'token' => $token,
                    'message' => 'Login successful'
                ]);
            }

            // For normal users: Check if they have a phone for OTP
            if (!$user->phone) {
                return response()->json([
                    'success' => false,
                    'message' => __('auth.phone_required_for_otp'),
                ], 400);
            }

            // For normal users: send login OTP using OtpService
            try {
                $result = $this->otpService->send($user->phone, 'login');
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Auth login: OTP send failed', [
                    'user_id' => $user->id,
                    'phone' => $user->phone,
                    'error' => $e->getMessage()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => __('auth.failed_send_otp'),
                ], 500);
            }

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], $result['cooldown'] ?? false ? 429 : 400);
            }

            return response()->json([
                'success' => true,
                'message' => __('auth.otp_sent'),
                'requires_otp' => true,
                'phone' => $user->phone,
                // Include fixed OTP in dev mode for convenience
                'dev_otp' => $this->otpService->isFixedMode() ? $result['code'] : null,
            ]);
            
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Auth login: Unexpected error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Login failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify OTP and complete authentication (for both login and register)
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string',
            'type' => 'nullable|in:login,register',
        ]);

        $type = $request->get('type', 'login');
        $result = $this->otpService->verify($request->phone, $request->code, $type);

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }


    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $user->load('roles.permissions');
        
        // Get all permission names for the user
        $permissions = $user->roles->flatMap(fn($role) => $role->permissions->pluck('name'))->unique()->values();
        
        return response()->json([
            'user' => $user,
            'roles' => $user->roles->pluck('name'),
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|string|max:20|unique:users,phone,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'user' => $user,
            'message' => 'Profile updated successfully',
        ]);
    }
}
