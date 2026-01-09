<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Get all payments for authenticated user
     */
    public function index(Request $request)
    {
        $payments = Payment::with('booking')
            ->whereHas('booking', function($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['payments' => $payments]);
    }

    /**
     * Initiate payment (create payment session and return payment URL)
     */
    public function initiate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|in:credit_card,mada,apple_pay',
            'gateway' => 'nullable|string|in:telr,moyasar,test',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking = Booking::find($request->booking_id);

        // Verify booking belongs to user
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Check if booking already paid
        if ($booking->payment_status === 'paid') {
            return response()->json(['message' => 'Booking already paid'], 422);
        }

        // Create payment record
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'method' => $request->method,
            'status' => 'pending',
            'transaction_id' => null,
            'meta' => [
                'amount' => $request->amount,
                'currency' => 'SAR',
                'gateway' => $request->gateway ?? 'test',
                'initiated_at' => now()->toISOString(),
            ]
        ]);

        // Choose gateway
        $gateway = $request->gateway ?? 'test';

        if ($gateway === 'telr') {
            $result = $this->initiateTelrPayment($payment, $booking, $request->amount);
        } elseif ($gateway === 'moyasar') {
            $result = $this->initiateMoyasarPayment($payment, $booking, $request->amount);
        } else {
            // Test mode - no real payment
            $result = $this->initiateTestPayment($payment, $booking, $request->amount);
        }

        if ($result['success']) {
            return response()->json([
                'payment' => $payment->fresh(),
                'payment_url' => $result['payment_url'] ?? null,
                'redirect_url' => $result['redirect_url'] ?? null,
                'message' => 'Payment initiated successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to initiate payment',
                'error' => $result['error'] ?? 'Unknown error'
            ], 500);
        }
    }

    /**
     * Initiate Telr payment
     */
    private function initiateTelrPayment($payment, $booking, $amount)
    {
        // Telr Test Mode Configuration
        $storeId = config('services.telr.store_id', '25484'); // Test store ID
        $authKey = config('services.telr.auth_key', 'tF@zx^Gq5W'); // Test auth key
        
        $returnUrl = config('app.frontend_url') . '/payment/callback';
        $callbackUrl = config('app.url') . '/api/payments/webhook/telr';

        try {
            $response = Http::post('https://secure.telr.com/gateway/order.json', [
                'method' => 'create',
                'store' => $storeId,
                'authkey' => $authKey,
                'order' => [
                    'cartid' => $payment->id,
                    'test' => 1, // Test mode
                    'amount' => $amount,
                    'currency' => 'SAR',
                    'description' => "Booking #{$booking->id} - Tilal Rimal",
                ],
                'return' => [
                    'authorised' => $returnUrl . '?status=success&payment_id=' . $payment->id,
                    'declined' => $returnUrl . '?status=declined&payment_id=' . $payment->id,
                    'cancelled' => $returnUrl . '?status=cancelled&payment_id=' . $payment->id,
                ],
                'webhook' => [
                    'url' => $callbackUrl,
                ],
            ]);

            $data = $response->json();

            if (isset($data['order']['url'])) {
                // Update payment with transaction reference
                $payment->update([
                    'transaction_id' => $data['order']['ref'] ?? null,
                    'meta' => array_merge($payment->meta ?? [], [
                        'telr_order_ref' => $data['order']['ref'] ?? null,
                        'telr_response' => $data,
                    ])
                ]);

                return [
                    'success' => true,
                    'payment_url' => $data['order']['url'],
                    'redirect_url' => $data['order']['url'],
                ];
            }

            return [
                'success' => false,
                'error' => $data['error']['message'] ?? 'Failed to create Telr order'
            ];

        } catch (\Exception $e) {
            Log::error('Telr payment initiation failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Initiate Moyasar payment
     */
    private function initiateMoyasarPayment($payment, $booking, $amount)
    {
        $apiKey = config('services.moyasar.api_key', 'pk_test_vcFUHJDBwiyRu4Bd3hFuPpThb6Zf2eMn8wGzxHJ');
        $callbackUrl = config('app.frontend_url') . '/payment/callback?payment_id=' . $payment->id;

        try {
            $response = Http::withBasicAuth($apiKey, '')
                ->post('https://api.moyasar.com/v1/payments', [
                    'amount' => $amount * 100, // Amount in halalas
                    'currency' => 'SAR',
                    'description' => "Booking #{$booking->id} - Tilal Rimal",
                    'callback_url' => $callbackUrl,
                    'source' => [
                        'type' => 'creditcard',
                    ],
                ]);

            $data = $response->json();

            if (isset($data['id'])) {
                $payment->update([
                    'transaction_id' => $data['id'],
                    'meta' => array_merge($payment->meta ?? [], [
                        'moyasar_payment_id' => $data['id'],
                        'moyasar_response' => $data,
                    ])
                ]);

                return [
                    'success' => true,
                    'payment_url' => $data['source']['transaction_url'] ?? null,
                    'redirect_url' => $data['source']['transaction_url'] ?? null,
                ];
            }

            return [
                'success' => false,
                'error' => $data['message'] ?? 'Failed to create Moyasar payment'
            ];

        } catch (\Exception $e) {
            Log::error('Moyasar payment initiation failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Initiate test payment (for development)
     */
    private function initiateTestPayment($payment, $booking, $amount)
    {
        // Immediately mark as paid for test mode (no external gateway)
        $payment->update([
            'status' => 'paid',
            'transaction_id' => 'TEST_' . time(),
            'meta' => array_merge($payment->meta ?? [], [
                'test_mode' => true,
                'amount' => $amount,
                'paid_at' => now()->toISOString(),
            ]),
        ]);

        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        return [
            'success' => true,
            'payment_url' => null,
            'redirect_url' => null,
        ];
    }

    /**
     * Telr webhook handler
     */
    public function telrWebhook(Request $request)
    {
        Log::info('Telr webhook received', $request->all());

        $cartId = $request->input('cartid');
        $status = $request->input('status');
        $transactionRef = $request->input('tranref');

        $payment = Payment::find($cartId);

        if (!$payment) {
            Log::error('Payment not found for Telr webhook', ['cart_id' => $cartId]);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $booking = $payment->booking;

        if ($status === 'A') { // Authorised
            $payment->update([
                'status' => 'paid',
                'transaction_id' => $transactionRef,
                'meta' => array_merge($payment->meta ?? [], [
                    'telr_webhook' => $request->all(),
                    'paid_at' => now()->toISOString(),
                ])
            ]);

            $booking->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
            ]);

            return response()->json(['message' => 'Payment confirmed']);
        } elseif ($status === 'D') { // Declined
            $payment->update([
                'status' => 'failed',
                'meta' => array_merge($payment->meta ?? [], [
                    'telr_webhook' => $request->all(),
                    'declined_at' => now()->toISOString(),
                ])
            ]);

            return response()->json(['message' => 'Payment declined']);
        }

        return response()->json(['message' => 'Webhook received']);
    }

    /**
     * Moyasar webhook handler
     */
    public function moyasarWebhook(Request $request)
    {
        Log::info('Moyasar webhook received', $request->all());

        $paymentId = $request->input('id');
        $status = $request->input('status');

        $payment = Payment::where('transaction_id', $paymentId)->first();

        if (!$payment) {
            Log::error('Payment not found for Moyasar webhook', ['payment_id' => $paymentId]);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $booking = $payment->booking;

        if ($status === 'paid') {
            $payment->update([
                'status' => 'paid',
                'meta' => array_merge($payment->meta ?? [], [
                    'moyasar_webhook' => $request->all(),
                    'paid_at' => now()->toISOString(),
                ])
            ]);

            $booking->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
            ]);

            return response()->json(['message' => 'Payment confirmed']);
        } elseif ($status === 'failed') {
            $payment->update([
                'status' => 'failed',
                'meta' => array_merge($payment->meta ?? [], [
                    'moyasar_webhook' => $request->all(),
                    'failed_at' => now()->toISOString(),
                ])
            ]);

            return response()->json(['message' => 'Payment failed']);
        }

        return response()->json(['message' => 'Webhook received']);
    }

    /**
     * Payment callback (user returns from payment gateway)
     */
    public function callback(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $status = $request->input('status', 'pending');

        $payment = Payment::find($paymentId);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        return response()->json([
            'payment' => $payment->fresh(),
            'booking' => $payment->booking,
            'status' => $status,
        ]);
    }

    /**
     * Get payment details
     */
    public function show(Request $request, $id)
    {
        $payment = Payment::with('booking')->find($id);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Verify user can access this payment
        if ($request->user() && $payment->booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['payment' => $payment]);
    }
}
