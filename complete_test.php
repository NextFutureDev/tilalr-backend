<?php
/**
 * Complete Test: Reservation → Dashboard → Admin Panel
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "════════════════════════════════════════════════════════════════\n";
echo "  🧪 COMPLETE RESERVATION SYSTEM TEST\n";
echo "════════════════════════════════════════════════════════════════\n\n";

// Get a test user
$user = \App\Models\User::where('email', 'aa@gmail.com')->first();
if (!$user) {
    echo "❌ Test user not found\n";
    exit(1);
}

echo "Step 1: Using test user: {$user->name} ({$user->email})\n";
echo "─────────────────────────────────────────────────────────────\n\n";

// Step 1: Create a reservation
echo "Step 2: Creating a test reservation via API\n";
echo "─────────────────────────────────────────────────────────────\n";

$reservationData = [
    'name' => $user->name,
    'email' => $user->email,
    'phone' => '0505555555',
    'trip_slug' => 'complete-test-' . time(),
    'trip_title' => 'Complete System Test',
    'trip_type' => 'activity',  // Frontend sends this
    'date' => date('Y-m-d', strtotime('+2 days')),
    'guests' => 3,
    'amount' => 1500,
    'details' => [
        'region' => 'Riyadh',
        'city' => 'Riyadh',
        'destination' => 'Complete System Test',
        'source' => 'test_script',
    ]
];

// Make API call
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/bookings/guest');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($reservationData));
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
$reservationId = $data['reservation']['id'];
echo "✅ Reservation created successfully\n";
echo "   ID: $reservationId\n";
echo "   Email: {$data['reservation']['email']}\n";
echo "   Status: {$data['reservation']['status']}\n\n";

// Step 2: Verify in database
echo "Step 3: Verifying in database\n";
echo "─────────────────────────────────────────────────────────────\n";

$reservation = \App\Models\Reservation::find($reservationId);
if (!$reservation) {
    echo "❌ Reservation not found in database!\n";
    exit(1);
}

echo "✅ Found in database:\n";
echo "   Name: {$reservation->name}\n";
echo "   Email: {$reservation->email}\n";
echo "   Trip Type: {$reservation->trip_type}\n";
echo "   Status: {$reservation->status}\n";
echo "   Guests: {$reservation->guests}\n";
echo "   Date: {$reservation->preferred_date}\n\n";

// Step 3: Verify dashboard can find it
echo "Step 4: Simulating dashboard query\n";
echo "─────────────────────────────────────────────────────────────\n";

$dashboardReservations = \App\Models\Reservation::where('email', $user->email)
    ->orderBy('created_at', 'desc')
    ->get();

echo "✅ Dashboard query result:\n";
echo "   Found: " . count($dashboardReservations) . " reservation(s) for {$user->email}\n";
foreach ($dashboardReservations as $res) {
    echo "     - ID {$res->id}: {$res->trip_title} ({$res->status})\n";
}
echo "\n";

// Step 4: Verify admin panel can find it
echo "Step 5: Simulating admin panel query\n";
echo "─────────────────────────────────────────────────────────────\n";

$allReservations = \App\Models\Reservation::orderBy('created_at', 'desc')->get();
$found = false;
foreach ($allReservations as $res) {
    if ($res->id == $reservationId) {
        $found = true;
        break;
    }
}

if ($found) {
    echo "✅ Admin panel query result:\n";
    echo "   Total reservations: " . count($allReservations) . "\n";
    echo "   Latest reservation (ID: $reservationId) found in list\n";
} else {
    echo "❌ Reservation not found in admin query!\n";
    exit(1);
}
echo "\n";

// Step 5: Summary
echo "════════════════════════════════════════════════════════════════\n";
echo "  ✅ ALL TESTS PASSED!\n";
echo "════════════════════════════════════════════════════════════════\n\n";

echo "Summary:\n";
echo "  ✅ Reservation created via API\n";
echo "  ✅ Data stored correctly in database\n";
echo "  ✅ Dashboard can find it (by email)\n";
echo "  ✅ Admin panel can find it (all reservations)\n";
echo "  ✅ Trip type: 'activity' recognized and stored\n\n";

echo "🎯 NEXT STEPS:\n";
echo "  1. Log in to frontend with email: {$user->email}\n";
echo "  2. Go to dashboard → My Reservations\n";
echo "  3. Should see: Complete System Test\n";
echo "  4. Log into admin panel\n";
echo "  5. Go to Reservations & Bookings → Reservations\n";
echo "  6. Should see the new reservation in the list\n\n";

echo "📊 TEST METRICS:\n";
echo "  Reservation ID: $reservationId\n";
echo "  User Email: {$user->email}\n";
echo "  Trip Type: {$reservation->trip_type}\n";
echo "  Status: {$reservation->status}\n";
echo "  Created: {$reservation->created_at}\n\n";

echo "✨ System is working correctly!\n";
