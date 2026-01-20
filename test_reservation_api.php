<?php
/**
 * Test the reservation creation API endpoint
 */

// Simulate a POST request to the guest booking endpoint
$testData = [
    'name' => 'Test User',
    'email' => 'testuser@example.com',
    'phone' => '0501234567',
    'trip_slug' => 'test-activity',
    'trip_title' => 'Test Activity',
    'trip_type' => 'activity',
    'date' => date('Y-m-d', strtotime('+1 day')),
    'guests' => 2,
    'amount' => 500,
    'details' => [
        'region' => 'Riyadh',
        'city' => 'Riyadh',
        'destination' => 'Test Activity',
    ]
];

echo "=== Testing Reservation Creation API ===\n\n";
echo "📤 Sending test data to /api/bookings/guest\n";
echo json_encode($testData, JSON_PRETTY_PRINT) . "\n\n";

// Make the API call
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/bookings/guest');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "❌ CURL Error: $error\n";
} else {
    echo "Status Code: $httpCode\n\n";
    $data = json_decode($response, true);
    
    if ($httpCode === 201 || $httpCode === 200) {
        echo "✅ SUCCESS!\n";
        echo json_encode($data, JSON_PRETTY_PRINT) . "\n\n";
        
        // Check database
        echo "=== Verifying in Database ===\n";
        require 'vendor/autoload.php';
        $app = require 'bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        $reservation = \App\Models\Reservation::latest()->first();
        if ($reservation) {
            echo "✅ Found in DB:\n";
            echo "ID: {$reservation->id}\n";
            echo "Email: {$reservation->email}\n";
            echo "Status: {$reservation->status}\n";
            echo "Trip Type: {$reservation->trip_type}\n";
        }
    } else {
        echo "❌ FAILED!\n";
        echo "Response: $response\n";
    }
}
