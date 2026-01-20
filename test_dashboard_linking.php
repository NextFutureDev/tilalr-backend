<?php
/**
 * Test: Create reservation with logged-in user's email and verify it shows in dashboard
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Test: Reservation-Dashboard Linking ===\n\n";

// Use a real user's email from the database
$user = \App\Models\User::where('email', 'aa@gmail.com')->first();
if (!$user) {
    echo "❌ User with email aa@gmail.com not found\n";
    exit(1);
}

echo "📤 Found user: {$user->name} ({$user->email})\n\n";

// Create a test reservation with that user's email
$testData = [
    'name' => $user->name,
    'email' => $user->email,
    'phone' => '0501234567',
    'trip_slug' => 'test-activity-' . time(),
    'trip_title' => 'Test Activity for Dashboard',
    'trip_type' => 'activity',
    'date' => date('Y-m-d', strtotime('+1 day')),
    'guests' => 2,
    'amount' => 500,
    'details' => [
        'region' => 'Riyadh',
        'city' => 'Riyadh',
        'destination' => 'Test Activity for Dashboard',
    ]
];

echo "📤 Creating reservation with email: {$user->email}\n";
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
curl_close($ch);

if ($httpCode !== 201) {
    echo "❌ API call failed with code $httpCode\n";
    echo "Response: $response\n";
    exit(1);
}

$data = json_decode($response, true);
echo "✅ Reservation created: ID {$data['reservation']['id']}\n\n";

// Now check if the reservation is findable by email
echo "=== Checking Database ===\n";
$reservations = \App\Models\Reservation::where('email', $user->email)->get();
echo "✅ Found " . count($reservations) . " reservations for email: {$user->email}\n";

foreach ($reservations as $res) {
    echo "  - ID: {$res->id}, Trip: {$res->trip_title}, Status: {$res->status}\n";
}

echo "\n=== VERIFICATION ===\n";
if (count($reservations) > 0) {
    echo "✅ READY FOR DASHBOARD!\n";
    echo "When user logs in with email {$user->email},\n";
    echo "their dashboard should show " . count($reservations) . " reservation(s)\n";
} else {
    echo "❌ NO RESERVATIONS FOUND FOR THIS EMAIL\n";
}
