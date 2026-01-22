<?php
/**
 * Test script to verify reservation data is being saved correctly
 * with numberOfGuests and roomsNearEachOther fields
 */

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = \Illuminate\Http\Request::capture()
);

use App\Models\Reservation;

// Get the latest reservation
$latestReservation = Reservation::latest('id')->first();

if (!$latestReservation) {
    echo "❌ No reservations found in database\n";
    exit(1);
}

echo "\n✅ LATEST RESERVATION DATA:\n";
echo "========================================\n";
echo "ID: " . $latestReservation->id . "\n";
echo "Name: " . $latestReservation->name . "\n";
echo "Email: " . $latestReservation->email . "\n";
echo "Phone: " . $latestReservation->phone . "\n";
echo "Trip Type: " . $latestReservation->trip_type . "\n";
echo "Trip Title: " . $latestReservation->trip_title . "\n";
echo "Status: " . $latestReservation->status . "\n";
echo "\n📊 GUEST INFO:\n";
echo "  Guests (main column): " . ($latestReservation->guests ?? 'NULL') . "\n";
echo "  Guests (from details): " . ($latestReservation->booking_guest_count ?? 'N/A') . "\n";
echo "\n🏨 ROOM INFO:\n";

$roomInfo = $latestReservation->room_info;
if ($roomInfo) {
    echo "  Room Count: " . $roomInfo['roomCount'] . "\n";
    echo "  Rooms Near Each Other: " . ($roomInfo['roomsNearEachOther'] ? 'YES ✓' : 'NO ✗') . "\n";
    echo "  Adjacent Rooms Count: " . $roomInfo['roomsNearEachOtherCount'] . "\n";
    echo "  Room Type: " . ($roomInfo['roomType'] ?? 'N/A') . "\n";
    echo "  Room Summary: " . $latestReservation->room_summary . "\n";
} else {
    echo "  No room information in this reservation\n";
}

echo "\n📝 FULL DETAILS (JSON):\n";
echo json_encode($latestReservation->details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
echo "\n========================================\n";

// Show last 5 reservations summary
echo "\n📋 LAST 5 RESERVATIONS:\n";
echo "========================================\n";
$reservations = Reservation::latest('id')->limit(5)->get();

foreach ($reservations as $res) {
    $guestCount = $res->booking_guest_count ?? $res->guests ?? 'N/A';
    $roomSummary = $res->room_summary ?? 'N/A';
    echo sprintf(
        "ID: %d | %s | Guests: %s | Rooms: %s | Status: %s\n",
        $res->id,
        $res->name,
        $guestCount,
        $roomSummary,
        $res->status
    );
}

echo "\n✅ Test complete!\n";
?>
