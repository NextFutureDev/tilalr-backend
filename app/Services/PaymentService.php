<?php

namespace App\Services;

use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    /**
     * Process the payment using Stripe.
     */
    public function process(Payment $payment, array $cardData = []): array
    {
        try {
            // Create a charge
            $charge = Charge::create([
                'amount' => $payment->booking->amount * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $cardData['token'], // Token from frontend
                'description' => 'Booking payment for ' . $payment->booking->id,
            ]);

            // Update the payment record
            $payment->status = 'paid';
            $payment->transaction_id = $charge->id;
            $payment->meta = ['stripe_charge' => $charge];
            $payment->save();

            return [
                'status' => 'paid',
                'transaction_id' => $charge->id,
                'payment_id' => $payment->id
            ];
        } catch (\Exception $e) {
            $payment->status = 'failed';
            $payment->meta = ['error' => $e->getMessage()];
            $payment->save();

            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'payment_id' => $payment->id
            ];
        }
    }
}