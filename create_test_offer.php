<?php
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\CustomPaymentOffer;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

DB::connection('mysql')->statement('SELECT 1'); // Test connection

$offer = CustomPaymentOffer::create([
    'customer_name' => 'Test Customer',
    'customer_email' => 'test@example.com',
    'customer_phone' => '+966501234567',
    'amount' => 150.00,
    'description' => 'Test payment offer for verification',
    'payment_status' => 'pending',
    'created_by' => 1,
]);

echo "Created offer with ID: " . $offer->id . "\n";
echo "Unique Link: " . $offer->unique_link . "\n";
echo "Payment URL: http://localhost:3001/en/pay-custom-offer/" . $offer->unique_link . "\n";
?>
