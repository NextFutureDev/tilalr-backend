<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OtpService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * OTP Controller - Handles OTP send and verify requests
 * 
 * Uses the centralized OtpService which supports:
 * - Fixed OTP mode (development): Always uses OTP_FIXED_CODE (default: 1234)
 * - Random mode: Generates random codes (logged for testing)
 * - SMS mode: Full SMS integration (for production)
 */
class OtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Send OTP to phone number
     * POST /api/auth/send-otp
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'type' => 'nullable|in:login,register,reset',
        ]);

        $phone = $request->phone;
        $type = $request->get('type', 'login');

        // For password reset, check if phone number is registered first
        if ($type === 'reset') {
            $user = $this->otpService->findUserByPhone($phone);
            if (!$user) {
                Log::info('Password reset OTP request - phone not registered', ['phone' => $phone]);
                return response()->json([
                    'success' => false,
                    'message' => 'This phone number is not registered. Please create a new account.',
                    'code' => 'NOT_REGISTERED'
                ], 404);
            }
        }

        $result = $this->otpService->send($phone, $type);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], $result['cooldown'] ?? false ? 429 : 400);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message'],
            // Include fixed OTP in dev mode for convenience
            'dev_otp' => $this->otpService->isFixedMode() ? $result['code'] : null,
            'mode' => $this->otpService->getMode(), // For debugging
        ]);
    }

    /**
     * Verify OTP code
     * POST /api/auth/verify-otp
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string',
            'type' => 'nullable|in:login,register',
        ]);

        $phone = $request->phone;
        $code = $request->code;
        $type = $request->get('type', 'login');

        $result = $this->otpService->verify($phone, $code, $type);

        if (!$result['success']) {
            $statusCode = 400;
            if (str_contains($result['message'] ?? '', 'expired')) {
                $statusCode = 410;
            } elseif (str_contains($result['message'] ?? '', 'Maximum attempts')) {
                $statusCode = 429;
            } elseif (str_contains($result['message'] ?? '', 'not found')) {
                $statusCode = 404;
            }

            return response()->json($result, $statusCode);
        }

        return response()->json($result);
    }

    /**
     * Reset password after verifying OTP
     * POST /api/auth/reset-password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $phone = $request->phone;
        $code = $request->code;
        $password = $request->password;

        // Verify the code itself (do not require a user match at this stage)
        $result = $this->otpService->verifyCode($phone, $code, 'reset');

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        // Attempt to find user using flexible phone matching
        $user = $this->otpService->findUserByPhone($phone);

        if (!$user) {
            // Debug info: include phone and candidate evidence in log to help troubleshooting
            Log::info('Password reset failed - user not found for phone', ['phone' => $phone]);
            return response()->json([
                'success' => false, 
                'message' => 'This phone number is not registered. Please create a new account.',
                'code' => 'NOT_REGISTERED'
            ], 404);
        }

        $user->password = Hash::make($password);
        $user->save();

        Log::info('Password reset successful for user', ['user_id' => $user->id]);

        return response()->json(['success' => true, 'message' => 'Password reset successfully.']);
    }
}


