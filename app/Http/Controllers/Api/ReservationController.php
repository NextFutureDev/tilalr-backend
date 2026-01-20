<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;
use App\Mail\NewReservation;
use App\Mail\ReservationConfirmation;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    /**
     * Get all reservations (admin)
     */
    public function index(Request $request)
    {
        $query = Reservation::query();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by trip type
        if ($request->has('trip_type') && $request->trip_type) {
            $query->where('trip_type', $request->trip_type);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date) {
            $query->where('created_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->where('created_at', '<=', $request->to_date);
        }

        // Filter by contacted status
        if ($request->has('contacted')) {
            $query->where('admin_contacted', $request->boolean('contacted'));
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($reservations);
    }

    /**
     * Create a new reservation (public - no auth required)
     */
    public function store(Request $request)
    {
        // Manually resolve user from bearer token (since this route is public)
        $user = null;
        $authHeader = $request->header('Authorization');
        if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
            $token = substr($authHeader, 7);
            // Log token fingerprint (masked) for debugging
            try {
                \Illuminate\Support\Facades\Log::info('Reservation auth token extracted', ['token_preview' => substr($token,0,8) . '...']);
            } catch (\Throwable $e) {}

            $personalAccessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            if ($personalAccessToken) {
                try {
                    \Illuminate\Support\Facades\Log::info('PersonalAccessToken found', ['id' => $personalAccessToken->id, 'tokenable_type' => $personalAccessToken->tokenable_type, 'tokenable_id' => $personalAccessToken->tokenable_id]);
                } catch (\Throwable $e) {}
                $user = $personalAccessToken->tokenable;
            } else {
                try {
                    \Illuminate\Support\Facades\Log::info('PersonalAccessToken not found for provided token');
                } catch (\Throwable $e) {}
            }
        }

        // Debug: log incoming auth header and resolved user (if any)
        try {
            \Illuminate\Support\Facades\Log::info('Incoming reservation request', [
                'authorization' => $authHeader,
                'user_id_resolved' => $user?->id ?? null,
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);
        } catch (\Throwable $e) {
            // ignore logging issues
        }

        // If we couldn't resolve user from token, try to match by provided email
        if (!$user && $request->input('email')) {
            try {
                $foundUser = \App\Models\User::where('email', $request->input('email'))->first();
                if ($foundUser) {
                    $user = $foundUser;
                    \Illuminate\Support\Facades\Log::info('Reservation fallback matched user by email', ['user_id' => $user->id, 'email' => $user->email]);
                } else {
                    \Illuminate\Support\Facades\Log::info('Reservation fallback: no user found by email', ['email' => $request->input('email')]);
                }
            } catch (\Throwable $e) {
                // ignore lookup errors
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'trip_type' => 'nullable|string|in:school,corporate,family,private',
            'trip_slug' => 'nullable|string|max:255',
            'trip_title' => 'nullable|string|max:255',
            'preferred_date' => 'nullable|date|after_or_equal:yesterday',
            'guests' => 'nullable|integer|min:1|max:500',
            'notes' => 'nullable|string|max:2000',
            'details' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // If a user is authenticated, prefer their account info and link the reservation
        $reservation = Reservation::create([
            'user_id' => $user?->id ?? null,
            'name' => $user?->name ?? $request->name,
            'email' => $user?->email ?? $request->email,
            'phone' => $request->phone,
            'trip_type' => $request->trip_type,
            'trip_slug' => $request->trip_slug,
            'trip_title' => $request->trip_title,
            'preferred_date' => $request->preferred_date,
            'guests' => $request->guests ?? 1,
            'notes' => $request->notes,
            'details' => $request->details,
            'status' => 'pending',
        ]);

        // Send email notification to admin
        try {
            $adminEmail = config('mail.from.address', 'admin@tilrimal.com');
            Mail::to($adminEmail)->send(new NewReservation($reservation));
        } catch (\Exception $e) {
            \Log::error('Failed to send admin reservation email: ' . $e->getMessage());
        }

        // Send confirmation email to user
        try {
            Mail::to($reservation->email)->send(new ReservationConfirmation($reservation));
        } catch (\Exception $e) {
            \Log::error('Failed to send user reservation confirmation: ' . $e->getMessage());
        }

        // Debug log: show reservation created and linked user if any
        try {
            \Illuminate\Support\Facades\Log::info('Reservation created', ['reservation_id' => $reservation->id, 'user_id' => $reservation->user_id, 'email' => $reservation->email, 'phone' => $reservation->phone]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }

        return response()->json([
            'success' => true,
            'reservation' => $reservation,
            'message' => 'Your reservation request has been submitted successfully. Our team will contact you within 24 hours to confirm availability and next steps.'
        ], 201);
    }

    /**
     * Get reservation details
     */
    public function show($id)
    {
        $reservation = Reservation::with('convertedBooking')->find($id);

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'reservation' => $reservation
        ]);
    }

    /**
     * Check reservation status (public - by email and ID)
     */
    public function checkStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'reservation_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $reservation = Reservation::where('id', $request->reservation_id)
            ->where('email', $request->email)
            ->first();

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation not found with the provided details'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'reservation' => [
                'id' => $reservation->id,
                'status' => $reservation->status,
                'trip_title' => $reservation->trip_title,
                'preferred_date' => $reservation->preferred_date,
                'guests' => $reservation->guests,
                'created_at' => $reservation->created_at,
                'admin_contacted' => $reservation->admin_contacted,
            ]
        ]);
    }

    /**
     * Get authenticated user's reservations (by email)
     */
    public function myReservations(Request $request)
    {
        $user = $request->user();
        
        if (!$user || !$user->email) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated or email not found'
            ], 401);
        }

        $reservations = Reservation::where(function($q) use ($user) {
                // Prefer explicit user ownership when available, but also include any matching email
                $q->where('user_id', $user->id)
                  ->orWhere('email', $user->email);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'name' => $reservation->name,
                    'email' => $reservation->email,
                    'trip_title' => $reservation->trip_title,
                    'trip_type' => $reservation->trip_type,
                    'status' => $reservation->status,
                    'preferred_date' => $reservation->preferred_date,
                    'guests' => $reservation->guests,
                    'admin_contacted' => $reservation->admin_contacted,
                    'converted_booking_id' => $reservation->converted_booking_id,
                    'created_at' => $reservation->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'reservations' => $reservations
        ]);
    }

    /**
     * Update reservation status (admin)
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|string|in:pending,contacted,confirmed,converted,cancelled',
            'admin_contacted' => 'sometimes|boolean',
            'admin_notes' => 'sometimes|nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->has('admin_contacted') && $request->admin_contacted && !$reservation->admin_contacted) {
            $reservation->contacted_at = now();
        }

        $reservation->fill($request->only(['status', 'admin_contacted', 'admin_notes']));
        $reservation->save();

        return response()->json([
            'success' => true,
            'reservation' => $reservation,
            'message' => 'Reservation updated successfully'
        ]);
    }

    /**
     * Mark reservation as contacted
     */
    public function markContacted($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation not found'
            ], 404);
        }

        $reservation->update([
            'admin_contacted' => true,
            'contacted_at' => now(),
            'status' => $reservation->status === 'pending' ? 'contacted' : $reservation->status,
        ]);

        return response()->json([
            'success' => true,
            'reservation' => $reservation,
            'message' => 'Reservation marked as contacted'
        ]);
    }

    /**
     * Convert reservation to booking
     */
    public function convertToBooking(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation not found'
            ], 404);
        }

        if ($reservation->isConverted()) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation has already been converted to a booking'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Create booking from reservation
        $booking = \App\Models\Booking::create([
            'user_id' => $request->user_id,
            'date' => $reservation->preferred_date,
            'guests' => $reservation->guests,
            'details' => array_merge($reservation->details ?? [], [
                'trip_slug' => $reservation->trip_slug,
                'trip_title' => $reservation->trip_title,
                'name' => $reservation->name,
                'email' => $reservation->email,
                'phone' => $reservation->phone,
                'amount' => $request->amount,
                'converted_from_reservation' => $reservation->id,
                'reservation_notes' => $reservation->notes,
            ]),
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Update reservation
        $reservation->update([
            'status' => 'converted',
            'converted_booking_id' => $booking->id,
        ]);

        return response()->json([
            'success' => true,
            'reservation' => $reservation,
            'booking' => $booking,
            'message' => 'Reservation converted to booking successfully'
        ]);
    }

    /**
     * Delete reservation (admin)
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservation not found'
            ], 404);
        }

        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation deleted successfully'
        ]);
    }

    /**
     * Get reservation statistics (admin)
     */
    public function statistics()
    {
        $stats = [
            'total' => Reservation::count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'contacted' => Reservation::where('status', 'contacted')->count(),
            'confirmed' => Reservation::where('status', 'confirmed')->count(),
            'converted' => Reservation::where('status', 'converted')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
            'not_contacted' => Reservation::where('admin_contacted', false)->count(),
            'by_trip_type' => [
                'school' => Reservation::where('trip_type', 'school')->count(),
                'corporate' => Reservation::where('trip_type', 'corporate')->count(),
                'family' => Reservation::where('trip_type', 'family')->count(),
                'private' => Reservation::where('trip_type', 'private')->count(),
            ],
            'today' => Reservation::whereDate('created_at', today())->count(),
            'this_week' => Reservation::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => Reservation::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json([
            'success' => true,
            'statistics' => $stats
        ]);
    }
}
