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
        $bookings = Booking::with(['payments'])
            ->where('user_id', $request->user()->id)
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
            'date' => 'required|date|after_or_equal:today',
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
     */
    public function guestStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'trip_slug' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'guests' => 'required|integer|min:1',
            'details' => 'nullable|array',
            'amount' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking = Booking::create([
            'user_id' => null, // Guest booking
            'service_id' => null,
            'date' => $request->date,
            'guests' => $request->guests,
            'details' => array_merge($request->input('details', []), [
                'trip_slug' => $request->trip_slug,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'amount' => $request->amount,
            ]),
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        try {
            Mail::to(config('mail.from.address'))->send(new NewBooking($booking));
        } catch (\Exception $e) {
            \Log::error('Failed to send booking email: ' . $e->getMessage());
        }

        return response()->json([
            'booking' => $booking,
            'message' => 'Booking request submitted successfully'
        ], 201);
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
        if ($request->user() && $booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
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
