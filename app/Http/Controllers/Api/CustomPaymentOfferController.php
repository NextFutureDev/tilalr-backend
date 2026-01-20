<?php

namespace App\Http\Controllers\Api;

use App\Models\CustomPaymentOffer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomPaymentOfferController extends Controller
{
    /**
     * Create a new custom payment offer (Super Admin only)
     */
    public function create(Request $request): JsonResponse
    {
        // Validate user is super admin
        $user = $request->user();
        if (!$user || !$user->hasRole('super_admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only Super Admins can create payment offers.',
            ], 403);
        }

        // Validate input
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:1000',
        ]);

        try {
            // Create offer (unique_link is auto-generated in model)
            $offer = CustomPaymentOffer::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'amount' => $validated['amount'],
                'description' => $validated['description'],
                'created_by' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment offer created successfully',
                'data' => [
                    'id' => $offer->id,
                    'customer_name' => $offer->customer_name,
                    'customer_email' => $offer->customer_email,
                    'customer_phone' => $offer->customer_phone,
                    'amount' => $offer->amount,
                    'description' => $offer->description,
                    'payment_link' => $offer->getPaymentUrl(),
                    'payment_status' => $offer->payment_status,
                    'created_at' => $offer->created_at,
                ],
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create payment offer', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment offer',
            ], 500);
        }
    }

    /**
     * Get all custom payment offers (Super Admin only)
     */
    public function list(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user || !$user->hasRole('super_admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        try {
            $query = CustomPaymentOffer::with('creator')
                ->orderBy('created_at', 'desc');

            // Filter by status if provided
            if ($request->has('status')) {
                $query->where('payment_status', $request->input('status'));
            }

            $offers = $query->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $offers->map(function ($offer) {
                    return [
                        'id' => $offer->id,
                        'customer_name' => $offer->customer_name,
                        'customer_email' => $offer->customer_email,
                        'customer_phone' => $offer->customer_phone,
                        'amount' => $offer->amount,
                        'description' => $offer->description,
                        'payment_link' => $offer->getPaymentUrl(),
                        'payment_status' => $offer->payment_status,
                        'moyasar_transaction_id' => $offer->moyasar_transaction_id,
                        'created_by' => $offer->creator?->name,
                        'created_at' => $offer->created_at,
                    ];
                }),
                'pagination' => [
                    'total' => $offers->total(),
                    'per_page' => $offers->perPage(),
                    'current_page' => $offers->currentPage(),
                    'last_page' => $offers->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch payment offers', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch offers',
            ], 500);
        }
    }

    /**
     * Get payment offer details by unique link (Public - for customer view)
     */
    public function show($uniqueLink): JsonResponse
    {
        try {
            $offer = CustomPaymentOffer::where('unique_link', $uniqueLink)->firstOrFail();

            // Check if already paid - show different response
            if ($offer->isPaid()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'customer_name' => $offer->customer_name,
                        'amount' => (float) $offer->amount,
                        'description' => $offer->description,
                        'payment_status' => $offer->payment_status,
                        'currency' => 'SAR',
                        'already_paid' => true,
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'customer_name' => $offer->customer_name,
                    'customer_email' => $this->maskEmail($offer->customer_email),
                    'customer_phone' => $this->maskPhone($offer->customer_phone),
                    'amount' => (float) $offer->amount,
                    'description' => $offer->description,
                    'payment_status' => $offer->payment_status,
                    'currency' => 'SAR',
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment offer not found or has expired',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to fetch offer', [
                'unique_link' => $uniqueLink,
                'error' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load payment offer',
            ], 500);
        }
    }

    /**
     * Handle successful payment from Moyasar
     */
    public function paymentSuccess($uniqueLink, Request $request): JsonResponse
    {
        try {
            $offer = CustomPaymentOffer::where('unique_link', $uniqueLink)->firstOrFail();

            // Check if already paid
            if ($offer->isPaid()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment already recorded',
                    'data' => [
                        'payment_status' => $offer->payment_status,
                        'amount' => $offer->amount,
                    ],
                ]);
            }

            // Get transaction ID from Moyasar callback
            $transactionId = $request->input('id') 
                ?? $request->input('transaction_id') 
                ?? $request->input('payment_id');

            // Validate Moyasar payment status if provided
            $moyasarStatus = $request->input('status');
            if ($moyasarStatus && strtolower($moyasarStatus) !== 'paid') {
                Log::warning('Moyasar payment not marked as paid', [
                    'unique_link' => $uniqueLink,
                    'status' => $moyasarStatus,
                ]);
                
                if (strtolower($moyasarStatus) === 'failed') {
                    $offer->markAsFailed();
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment failed',
                        'data' => ['payment_status' => 'failed'],
                    ]);
                }
            }

            // Mark as paid
            $offer->markAsPaid($transactionId);

            Log::info('Custom payment offer marked as paid', [
                'offer_id' => $offer->id,
                'transaction_id' => $transactionId,
                'amount' => $offer->amount,
            ]);

            // Send confirmation email
            $this->sendPaymentConfirmationEmail($offer);

            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully',
                'data' => [
                    'payment_status' => $offer->payment_status,
                    'amount' => $offer->amount,
                    'transaction_id' => $transactionId,
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment offer not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to process payment success', [
                'unique_link' => $uniqueLink,
                'error' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment',
            ], 500);
        }
    }

    /**
     * Handle payment failure
     */
    public function paymentFailed($uniqueLink, Request $request): JsonResponse
    {
        try {
            $offer = CustomPaymentOffer::where('unique_link', $uniqueLink)->firstOrFail();
            
            // Don't overwrite if already paid
            if ($offer->isPaid()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment already completed',
                    'data' => ['payment_status' => $offer->payment_status],
                ]);
            }

            $offer->markAsFailed();

            Log::info('Custom payment offer marked as failed', [
                'offer_id' => $offer->id,
                'error' => $request->input('error'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment failure recorded',
                'data' => ['payment_status' => $offer->payment_status],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment offer not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to process payment failure', [
                'unique_link' => $uniqueLink,
                'error' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment failure',
            ], 500);
        }
    }

    /**
     * Moyasar Webhook Handler
     */
    public function moyasarWebhook(Request $request): JsonResponse
    {
        Log::info('Moyasar webhook received for custom payment', $request->all());

        try {
            $paymentId = $request->input('id');
            $status = $request->input('status');
            $metadata = $request->input('metadata', []);
            
            // Find offer by unique_link in metadata or callback_url
            $uniqueLink = $metadata['unique_link'] ?? null;
            
            if (!$uniqueLink) {
                $callbackUrl = $request->input('callback_url', '');
                if (preg_match('/pay-custom-offer\/([a-zA-Z0-9-]+)/', $callbackUrl, $matches)) {
                    $uniqueLink = $matches[1];
                }
            }

            if (!$uniqueLink) {
                Log::warning('Could not determine offer from webhook', ['payment_id' => $paymentId]);
                return response()->json(['success' => false, 'message' => 'Offer not found'], 404);
            }

            $offer = CustomPaymentOffer::where('unique_link', $uniqueLink)->first();
            
            if (!$offer) {
                return response()->json(['success' => false, 'message' => 'Offer not found'], 404);
            }

            // Update based on payment status
            if (strtolower($status) === 'paid') {
                $offer->markAsPaid($paymentId);
                $this->sendPaymentConfirmationEmail($offer);
            } elseif (in_array(strtolower($status), ['failed', 'rejected'])) {
                $offer->markAsFailed();
            }

            return response()->json(['success' => true, 'message' => 'Webhook processed']);
        } catch (\Exception $e) {
            Log::error('Moyasar webhook processing failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Delete a custom payment offer (Super Admin only)
     */
    public function delete($id, Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user || !$user->hasRole('super_admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        try {
            $offer = CustomPaymentOffer::findOrFail($id);

            // Only allow deleting pending offers
            if ($offer->isPaid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete a paid offer',
                ], 400);
            }

            $offer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Payment offer deleted successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment offer not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to delete payment offer', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete offer',
            ], 500);
        }
    }

    /**
     * Send payment confirmation email
     */
    private function sendPaymentConfirmationEmail(CustomPaymentOffer $offer): void
    {
        try {
            Mail::send('emails.custom-payment-confirmation', [
                'customer_name' => $offer->customer_name,
                'amount' => number_format($offer->amount, 2),
                'description' => $offer->description,
                'transaction_id' => $offer->moyasar_transaction_id,
                'date' => $offer->updated_at->format('F d, Y h:i A'),
            ], function ($message) use ($offer) {
                $message->to($offer->customer_email, $offer->customer_name)
                    ->subject('Payment Confirmation - Tilal Rimal');
            });

            Log::info('Payment confirmation email sent', [
                'offer_id' => $offer->id,
                'email' => $offer->customer_email,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment confirmation email', [
                'offer_id' => $offer->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Mask email for privacy
     */
    private function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) return $email;
        
        $name = $parts[0];
        $domain = $parts[1];
        
        if (strlen($name) <= 2) {
            return $name . '***@' . $domain;
        }
        
        return substr($name, 0, 2) . str_repeat('*', min(strlen($name) - 2, 5)) . '@' . $domain;
    }

    /**
     * Mask phone for privacy
     */
    private function maskPhone(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($digits) < 4) return $phone;
        
        return substr($digits, 0, 3) . str_repeat('*', strlen($digits) - 6) . substr($digits, -3);
    }
}
