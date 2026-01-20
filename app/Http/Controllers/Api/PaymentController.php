<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

class PaymentController extends Controller
{
    /**
     * List payments (admin => all, user => own payments).
     * Returns an array in 'payments' so frontend code expecting paymentsRes.payments works.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
                // Admin: all payments (if Payment model exists), otherwise map bookings
                if (class_exists(\App\Models\Payment::class)) {
                    $payments = \App\Models\Payment::orderBy('created_at', 'desc')->get();
                } else {
                    $payments = Booking::orderBy('created_at', 'desc')->get()->map(function ($b) {
                        return [
                            'id' => $b->id,
                            'booking_id' => $b->id,
                            'status' => $b->payment_status,
                            'amount' => $b->paid_amount ?? $b->amount,
                            'currency' => 'SAR',
                            'created_at' => $b->updated_at ?? $b->created_at,
                        ];
                    });
                }
            } else {
                // Regular user: only their payments/bookings
                if (class_exists(\App\Models\Payment::class)) {
                    // The payments table stores booking_id but not user_id. Filter by the related booking's user_id.
                    $payments = \App\Models\Payment::whereHas('booking', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })->orderBy('created_at', 'desc')->get();
                } else {
                    $payments = Booking::where('user_id', $user->id)->orderBy('created_at', 'desc')->get()->map(function ($b) {
                        return [
                            'id' => $b->id,
                            'booking_id' => $b->id,
                            'status' => $b->payment_status,
                            'amount' => $b->paid_amount ?? $b->amount,
                            'currency' => 'SAR',
                            'created_at' => $b->updated_at ?? $b->created_at,
                        ];
                    });
                }
            }

            return response()->json([
                'success' => true,
                'payments' => $payments,
            ]);
        } catch (\Exception $e) {
            Log::error('Payments index failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to fetch payments'], 500);
        }
    }

    /**
     * Show single payment (by id) - works with Payment model or falls back to booking record.
     */
    public function show(Request $request, $id)
    {
        try {
            if (class_exists(\App\Models\Payment::class)) {
                $payment = \App\Models\Payment::find($id);
                if (!$payment) return response()->json(['success' => false, 'message' => 'Payment not found'], 404);
                // If user is not admin, ensure payment belongs to them by checking the related booking's user_id
                $user = $request->user();
                if ($user && !(method_exists($user, 'hasRole') && $user->hasRole('admin'))) {
                    // payment->booking may be null if booking deleted; deny access in that case
                    $booking = $payment->booking;
                    if (!$booking || $booking->user_id != $user->id) {
                        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                    }
                }
            }

            // Fallback: treat booking as payment-like record
            $booking = Booking::find($id);
            if (!$booking) return response()->json(['success' => false, 'message' => 'Payment not found'], 404);

            $user = $request->user();
            if ($user && !(method_exists($user, 'hasRole') && $user->hasRole('admin'))) {
                $ownsBooking = $booking->user_id === $user->id;
                $emailMatches = isset($booking->details['email']) && $booking->details['email'] === $user->email;
                if (! $ownsBooking && ! $emailMatches) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
            }
            $record = [
                'id' => $booking->id,
                'booking_id' => $booking->id,
                'status' => $booking->payment_status,
                'amount' => $booking->paid_amount ?? $booking->amount,
                'currency' => 'SAR',
                'created_at' => $booking->updated_at ?? $booking->created_at,
            ];

            return response()->json(['success' => true, 'payment' => $record]);
        } catch (\Exception $e) {
            Log::error('Payment show failed', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to fetch payment'], 500);
        }
    }

    public function initiate(Request $request)
    {
        Log::info('Payment initiation request', $request->all());

        // Validate request
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'sometimes|numeric|min:1',
        ]);

        // Get the booking
        $booking = Booking::find($request->input('booking_id'));

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        // Use booking amount if not provided (already in SAR)
        $amountInSar = $request->input('amount', $booking->amount ?? 100);
        
        // Convert SAR to halalas (1 SAR = 100 halalas)
        $amountInHalalas = $amountInSar * 100;

        // Moyasar configuration with Apple Pay disabled
        $moyasarConfig = [
            'publishable_api_key' => env('MOYASAR_PUBLISHABLE_KEY', 'pk_live_JjGYt4f9iWDGpc9uCE9FCMBvZ9u5FBa5SsQvEFAY'),
            'amount' => $amountInHalalas, // Amount in halalas
            'currency' => 'SAR', // Saudi Riyals
            'description' => 'دفع حجز - ' . ($booking->trip_slug ?? 'حجز'),
            'callback_url' => config('app.frontend_url') . '/payment-callback',
            // Explicitly specify payment methods to disable Apple Pay
            'methods' => ['creditcard', 'stcpay'],
            'metadata' => [
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id ?? null,
                'trip_slug' => $booking->trip_slug ?? 'unknown',
                'amount_sar' => $amountInSar,
            ],
            'language' => 'ar',
            'on_close' => config('app.frontend_url') . '/booking/' . $booking->id,
        ];

        Log::info('Payment initiated', [
            'booking_id' => $booking->id,
            'amount_sar' => $amountInSar,
            'amount_halalas' => $amountInHalalas
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم بدء عملية الدفع بنجاح',
            'payment_id' => 'PAY-' . time() . '-' . $booking->id,
            'booking_id' => $booking->id,
            'amount' => $amountInSar,
            'amount_halalas' => $amountInHalalas,
            'currency' => 'SAR',
            'moyasar_config' => $moyasarConfig,
        ]);
    }

    /**
     * Handle Moyasar payment callback (webhook)
     */
    public function callback(Request $request)
    {
        Log::info('Payment callback received', $request->all());

        $data = $request->all();
        
        // Verify payment with Moyasar API
        $paymentId = $data['id'] ?? null;
        
        if (!$paymentId) {
            Log::error('Payment callback missing ID', $data);
            return response()->json(['success' => false, 'message' => 'Invalid callback']);
        }

        // Verify payment using Moyasar API
        $payment = $this->verifyPayment($paymentId);
        
        if (!$payment) {
            Log::error('Payment verification failed', ['payment_id' => $paymentId]);
            return response()->json(['success' => false, 'message' => 'Payment verification failed']);
        }

        // Verify currency is SAR
        if (($payment['currency'] ?? '') !== 'SAR') {
            Log::error('Invalid currency in payment', [
                'payment_id' => $paymentId,
                'currency' => $payment['currency'] ?? 'unknown',
                'expected' => 'SAR'
            ]);
            return response()->json(['success' => false, 'message' => 'Invalid currency']);
        }

        // Get booking ID from metadata
        $bookingId = $payment['metadata']['booking_id'] ?? null;
        
        if (!$bookingId) {
            Log::error('No booking ID in payment metadata', $payment);
            return response()->json(['success' => false, 'message' => 'No booking associated']);
        }

        // Update booking payment status
        $booking = Booking::find($bookingId);
        
        if (!$booking) {
            Log::error('Booking not found', ['booking_id' => $bookingId]);
            return response()->json(['success' => false, 'message' => 'Booking not found']);
        }

        $amountInHalalas = $payment['amount'] ?? 0;
        $amountInSar = $amountInHalalas / 100;
        $originalAmountSar = $payment['metadata']['amount_sar'] ?? $amountInSar;
        $status = $payment['status'] ?? 'failed';
        
        if ($status === 'paid') {
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'amount' => $originalAmountSar,
                'paid_amount' => $amountInSar,
                'payment_method' => $payment['source']['type'] ?? 'unknown',
                'transaction_id' => $paymentId,
                'payment_details' => [
                    'payment_id' => $paymentId,
                    'method' => $payment['source']['type'] ?? 'unknown',
                    'amount_halalas' => $amountInHalalas,
                    'amount_sar' => $amountInSar,
                    'currency' => $payment['currency'] ?? 'SAR',
                    'transaction_id' => $payment['id'] ?? $paymentId,
                    'data' => $payment
                ],
                'paid_at' => now(),
            ]);
            
            Log::info('Payment completed successfully', [
                'booking_id' => $bookingId,
                'payment_id' => $paymentId,
                'amount_sar' => $amountInSar,
                'method' => $payment['source']['type'] ?? 'unknown'
            ]);
        } else {
            $booking->update([
                'payment_status' => 'failed',
                'status' => 'cancelled',
                'payment_details' => [
                    'payment_id' => $paymentId,
                    'status' => $status,
                    'amount_halalas' => $amountInHalalas,
                    'amount_sar' => $amountInSar,
                    'error' => $payment['message'] ?? 'Payment failed'
                ]
            ]);
            
            Log::warning('Payment failed', [
                'booking_id' => $bookingId,
                'payment_id' => $paymentId,
                'status' => $status,
                'amount_sar' => $amountInSar
            ]);
        }

        return response()->json([
            'success' => $status === 'paid',
            'message' => $status === 'paid' ? 'تم الدفع بنجاح' : 'فشل عملية الدفع',
            'booking_id' => $bookingId,
            'status' => $status,
            'amount_sar' => $amountInSar,
            'currency' => 'SAR',
            'redirect_url' => config('app.frontend_url') . '/booking/' . $bookingId . '?payment=' . $status
        ]);
    }

    /**
     * Webhook wrappers for different gateways
     * These simply forward to callback for now to avoid missing method errors.
     */
    public function telrWebhook(Request $request)
    {
        return $this->callback($request);
    }

    public function moyasarWebhook(Request $request)
    {
        return $this->callback($request);
    }

    /**
     * Verify payment with Moyasar API
     */
    private function verifyPayment($paymentId)
    {
        try {
            $secretKey = env('MOYASAR_SECRET_KEY', 'sk_live_CqsRUfH7SJ5H2dnJvdk654F4LvZb9FZs7ipNwyZJ');
            
            $client = new \GuzzleHttp\Client();
            $response = $client->get("https://api.moyasar.com/v1/payments/{$paymentId}", [
                'auth' => [$secretKey, ''],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $paymentData = json_decode($response->getBody(), true);
            
            Log::info('Payment verification response', [
                'payment_id' => $paymentId,
                'currency' => $paymentData['currency'] ?? 'unknown',
                'amount' => $paymentData['amount'] ?? 0
            ]);
            
            return $paymentData;
            
        } catch (\Exception $e) {
            Log::error('Payment verification error', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Check payment status
     */
    public function checkStatus(Request $request, $paymentId)
    {
        try {
            $payment = $this->verifyPayment($paymentId);
            
            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على عملية الدفع'
                ], 404);
            }

            // Convert halalas to SAR
            $amountInHalalas = $payment['amount'] ?? 0;
            $amountInSar = $amountInHalalas / 100;

            return response()->json([
                'success' => true,
                'payment' => [
                    'id' => $payment['id'] ?? $paymentId,
                    'status' => $payment['status'] ?? 'unknown',
                    'amount_halalas' => $amountInHalalas,
                    'amount_sar' => $amountInSar,
                    'currency' => $payment['currency'] ?? 'SAR',
                    'method' => $payment['source']['type'] ?? 'unknown',
                    'created_at' => $payment['created_at'] ?? null,
                    'metadata' => $payment['metadata'] ?? [],
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Payment status check error', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'فشل في التحقق من حالة الدفع'
            ], 500);
        }
    }

    /**
     * Test payment endpoint
     */
    public function test(Request $request)
    {
        $testAmount = $request->input('amount', 100); // Default 100 SAR
        
        $moyasarConfig = [
            'publishable_api_key' => env('MOYASAR_PUBLISHABLE_KEY', 'pk_live_JjGYt4f9iWDGpc9uCE9FCMBvZ9u5FBa5SsQvEFAY'),
            'amount' => $testAmount * 100, // Convert to halalas
            'currency' => 'SAR',
            'description' => 'دفع تجريبي',
            'callback_url' => config('app.frontend_url') . '/payment-callback',
            'methods' => ['creditcard', 'stcpay'], // Apple Pay disabled
            'language' => 'ar',
            'metadata' => [
                'test' => true,
                'amount_sar' => $testAmount,
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Test payment configuration',
            'config' => $moyasarConfig,
            'note' => 'Amount in SAR: ' . $testAmount . ' SAR = ' . ($testAmount * 100) . ' halalas'
        ]);
    }
}