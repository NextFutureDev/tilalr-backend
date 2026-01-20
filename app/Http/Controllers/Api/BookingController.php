<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Support\Facades\Validator;
use App\Mail\NewBooking;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Get all bookings for authenticated user
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $userEmail = $request->user()->email;

        // Return bookings belonging to the user, and also include any guest bookings
        // that were created without a user but have the same email in details -> email
        $bookings = Booking::with(['payments'])
            ->where(function($q) use ($userId, $userEmail) {
                $q->where('user_id', $userId)
                  ->orWhere(function($q2) use ($userEmail) {
                      $q2->whereNull('user_id')
                         ->where('details->email', $userEmail);
                  });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['bookings' => $bookings]);
    }

    /**
     * Create a booking (authenticated user)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trip_id' => 'nullable|exists:trips,id',
            'trip_slug' => 'nullable|string',
            'date' => 'required|date|after_or_equal:yesterday',
            'guests' => 'required|integer|min:1',
            'details' => 'nullable|array',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:credit_card,mada,apple_pay',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get trip details if trip_id or trip_slug provided
        $trip = null;
        if ($request->trip_id) {
            $trip = Trip::find($request->trip_id);
        } elseif ($request->trip_slug) {
            $trip = Trip::where('slug', $request->trip_slug)->first();
        }

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'service_id' => $trip ? $trip->id : null,
            'date' => $request->date,
            'guests' => $request->guests,
            'details' => array_merge($request->input('details', []), [
                'trip_slug' => $request->trip_slug,
                'trip_title' => $trip ? $trip->title : ($request->input('details.trip_title') ?? null),
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'phone' => $request->user()->phone ?? ($request->input('details.user_phone') ?? null),
            ]),
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        // Send email notification to admin
        try {
            $adminEmail = config('mail.from.address', 'admin@tilrimal.com');
            Mail::to($adminEmail)->send(new NewBooking($booking));
        } catch (\Exception $e) {
            \Log::error('Failed to send admin booking email: ' . $e->getMessage());
        }

        // Send confirmation email to user
        try {
            Mail::to($request->user()->email)->send(new BookingConfirmation($booking));
        } catch (\Exception $e) {
            \Log::error('Failed to send user booking confirmation: ' . $e->getMessage());
        }

        return response()->json([
            'booking' => $booking,
            'message' => 'Booking created successfully'
        ], 201);
    }

    /**
     * Guest booking (no authentication required)
     * Creates a RESERVATION (unpaid) instead of a direct booking
     */
    public function guestStore(Request $request)
    {
        \Log::info("🔴 Guest booking request received", [
            'payload' => $request->all(),
            'headers' => $request->headers->all(),
        ]);

        // Manually resolve user from bearer token (since this route is public)
        $user = null;
        $authHeader = $request->header('Authorization');
        if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
            $token = substr($authHeader, 7);
            try {
                \Log::info('Guest booking auth token extracted', ['token_preview' => substr($token,0,8) . '...']);
                $personalAccessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
                if ($personalAccessToken) {
                    $user = $personalAccessToken->tokenable;
                    \Log::info('Guest booking user resolved from token', ['user_id' => $user?->id, 'email' => $user?->email]);
                }
            } catch (\Throwable $e) {
                \Log::warning('Failed to resolve user from token', ['error' => $e->getMessage()]);
            }
        }

        // If we couldn't resolve user from token, try to match by provided email
        if (!$user && $request->input('email')) {
            try {
                $foundUser = \App\Models\User::where('email', $request->input('email'))->first();
                if ($foundUser) {
                    $user = $foundUser;
                    \Log::info('Guest booking fallback matched user by email', ['user_id' => $user->id, 'email' => $user->email]);
                }
            } catch (\Throwable $e) {
                // ignore lookup errors
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'trip_slug' => 'nullable|string',
            'trip_title' => 'nullable|string',
            'trip_type' => 'nullable|string|in:activity,hotel,flight,package,school,corporate,family,private',
            'date' => 'required|date|after_or_equal:yesterday',
            'guests' => 'required|integer|min:1',
            'details' => 'nullable|array',
            'amount' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            \Log::error("❌ Validation failed for guest booking", [
                'errors' => $validator->errors()->toArray(),
                'payload' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create RESERVATION (unpaid), not a direct booking
        try {
            $reservation = \App\Models\Reservation::create([
                'user_id' => $user?->id ?? null,
                'name' => $user?->name ?? $request->name,
                'email' => $user?->email ?? $request->email,
                'phone' => $request->phone,
                'trip_slug' => $request->trip_slug,
                'trip_title' => $request->trip_title,
                'trip_type' => $request->trip_type ?? 'activity',
                'preferred_date' => $request->date,
                'guests' => $request->guests,
                'details' => array_merge($request->input('details', []), [
                    'amount' => $request->amount,
                    'booking_type' => $request->trip_type,
                ]),
                'status' => 'pending',
                'admin_contacted' => false,
            ]);

            \Log::info("✅ Reservation created successfully", [
                'id' => $reservation->id,
                'user_id' => $reservation->user_id,
                'email' => $reservation->email,
                'trip_type' => $reservation->trip_type,
                'status' => $reservation->status,
            ]);

            return response()->json([
                'reservation' => [
                    'id' => $reservation->id,
                    'email' => $reservation->email,
                    'status' => $reservation->status,
                    'name' => $reservation->name,
                ],
                'message' => 'Reservation submitted successfully. Admin will contact you to confirm details.'
            ], 201);
        } catch (\Exception $e) {
            \Log::error("❌ Error creating reservation", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all(),
            ]);
            return response()->json([
                'message' => 'Failed to create reservation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get booking details
     */
    public function show(Request $request, $id)
    {
        $booking = Booking::with('payments')->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Ensure user can only see their own bookings
        if ($request->user()) {
            $user = $request->user();
            $ownsBooking = $booking->user_id === $user->id;
            $emailMatches = isset($booking->details['email']) && $booking->details['email'] === $user->email;
            if (! $ownsBooking && ! $emailMatches) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        return response()->json(['booking' => $booking]);
    }

    /**
     * Check booking status (public)
     */
    public function checkStatus($id)
    {
        $booking = Booking::select('id', 'status', 'payment_status', 'created_at')
            ->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json(['booking' => $booking]);
    }

    /**
     * Update booking
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Ensure user can only update their own bookings
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Only allow updates if booking is still pending
        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'Cannot update booking that is not pending'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'sometimes|date|after_or_equal:today',
            'guests' => 'sometimes|integer|min:1',
            'details' => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking->update($request->only(['date', 'guests', 'details']));

        return response()->json([
            'booking' => $booking,
            'message' => 'Booking updated successfully'
        ]);
    }

    /**
     * Cancel booking
     */
    public function destroy(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Ensure user can only cancel their own bookings
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Only allow cancellation if payment is not completed
        if ($booking->payment_status === 'paid') {
            return response()->json([
                'message' => 'Cannot cancel paid booking. Please contact support.'
            ], 422);
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        return response()->json([
            'message' => 'Booking cancelled successfully'
        ]);
    }
}
