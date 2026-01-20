#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CustomPaymentOffer;

// Check if offers exist
$count = CustomPaymentOffer::count();
echo "Total offers in database: $count\n\n";

if ($count > 0) {
    $offer = CustomPaymentOffer::first();
    echo "First offer details:\n";
    echo "- ID: " . $offer->id . "\n";
    echo "- Unique Link: " . $offer->unique_link . "\n";
    echo "- Customer Name: " . $offer->customer_name . "\n";
    echo "- Amount: " . $offer->amount . " SAR\n";
    echo "- Status: " . $offer->payment_status . "\n";
    echo "\nTest Payment URL:\n";
    echo "http://localhost:3000/en/pay-custom-offer/" . $offer->unique_link . "\n";
} else {
    echo "No custom payment offers found in database.\n";
    echo "Creating a test offer...\n\n";
    
    $offer = CustomPaymentOffer::create([
        'customer_name' => 'Test Customer',
        'customer_email' => 'test@tilalrimal.com',
        'customer_phone' => '+966552290338',
        'amount' => 250.50,
        'description' => 'Test payment for system verification',
        'payment_status' => 'pending',
        'created_by' => 1,
    ]);
    
    echo "✓ Test offer created!\n";
    echo "- ID: " . $offer->id . "\n";
    echo "- Unique Link: " . $offer->unique_link . "\n";
    echo "- Amount: " . $offer->amount . " SAR\n";
    echo "\nTest Payment URL:\n";
    echo "http://localhost:3000/en/pay-custom-offer/" . $offer->unique_link . "\n";
}
