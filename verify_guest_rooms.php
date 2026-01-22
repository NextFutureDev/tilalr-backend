#!/usr/bin/env php
<?php
/**
 * Quick verification script for guest count and rooms data
 * Run: php verify_guest_rooms.php
 */

require 'vendor/autoload.php';

// Boot Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = \Illuminate\Http\Request::capture()
);

use App\Models\Reservation;

echo "\n📊 GUEST COUNT & ROOMS DATA VERIFICATION\n";
echo "========================================\n\n";

// Get total reservations
$totalCount = Reservation::count();
echo "📈 Total Reservations: " . $totalCount . "\n\n";

if ($totalCount === 0) {
    echo "❌ No reservations found. Create a booking first!\n";
    exit(1);
}

// Get reservations with room data
$withRoomData = Reservation::whereNotNull('details->roomCount')->count();
$withGuestData = Reservation::whereNotNull('details->numberOfGuests')->count();
$withAdjacentRoom = Reservation::where('details->roomsNearEachOther', true)->count();

echo "📋 Data Distribution:\n";
echo "   ✓ With room count: " . $withRoomData . " / " . $totalCount . "\n";
echo "   ✓ With guest count: " . $withGuestData . " / " . $totalCount . "\n";
echo "   ✓ Requesting adjacent rooms: " . $withAdjacentRoom . " / " . $totalCount . "\n\n";

// Show last 10 reservations
echo "📝 LAST 10 RESERVATIONS:\n";
echo "────────────────────────────────────────────────────────────────\n";

$reservations = Reservation::latest('id')->limit(10)->get();

foreach ($reservations as $idx => $res) {
    $idx++;
    
    // Guest count
    $guestCount = $res->booking_guest_count ?? 'N/A';
    
    // Room info
    $roomInfo = $res->room_info;
    $roomStr = $roomInfo ? 
        "{$roomInfo['roomCount']} room" . ($roomInfo['roomCount'] > 1 ? 's' : '') .
        ($roomInfo['roomsNearEachOther'] ? " (adjacent)" : "") :
        'N/A';
    
    echo "\n#{$idx} ID:{$res->id} | {$res->name}\n";
    echo "    Status: {$res->status} | Trip: {$res->trip_type}\n";
    echo "    Guests: {$guestCount} | Rooms: {$roomStr}\n";
    echo "    Booked: {$res->created_at->format('Y-m-d H:i:s')}\n";
    
    // Show any issues
    if (!isset($res->details['numberOfGuests'])) {
        echo "    ⚠️  Missing: numberOfGuests in details\n";
    }
    if (!isset($res->details['roomCount']) && $res->trip_type === 'hotel') {
        echo "    ⚠️  Missing: roomCount in details (hotel booking)\n";
    }
}

echo "\n────────────────────────────────────────────────────────────────\n\n";

// Show detailed view of latest reservation
echo "🔍 LATEST RESERVATION (DETAILED):\n";
echo "────────────────────────────────────────────────────────────────\n";

$latest = Reservation::latest('id')->first();
if ($latest) {
    echo "\nID: {$latest->id}\n";
    echo "Name: {$latest->name}\n";
    echo "Email: {$latest->email}\n";
    echo "Phone: {$latest->phone}\n";
    echo "Trip Type: {$latest->trip_type}\n";
    echo "Trip Title: {$latest->trip_title}\n";
    echo "Status: {$latest->status}\n";
    echo "Created: {$latest->created_at->format('Y-m-d H:i:s')}\n";
    
    echo "\n📊 Guest & Room Data:\n";
    echo "   Main guests column: {$latest->guests}\n";
    echo "   booking_guest_count: {$latest->booking_guest_count}\n";
    echo "   room_summary: {$latest->room_summary}\n";
    
    if ($latest->room_info) {
        echo "\n   Room Details:\n";
        echo "     - Room Count: {$latest->room_info['roomCount']}\n";
        echo "     - Near Each Other: " . ($latest->room_info['roomsNearEachOther'] ? 'YES' : 'NO') . "\n";
        echo "     - Adjacent Count: {$latest->room_info['roomsNearEachOtherCount']}\n";
        echo "     - Room Type: " . ($latest->room_info['roomType'] ?? 'N/A') . "\n";
    }
    
    echo "\n📦 Details JSON Keys:\n";
    $keys = array_keys($latest->details ?? []);
    foreach (array_chunk($keys, 3) as $chunk) {
        echo "     • " . implode(", ", $chunk) . "\n";
    }
    
    echo "\n📋 Selected Details:\n";
    $selected = [
        'numberOfGuests' => $latest->details['numberOfGuests'] ?? null,
        'roomCount' => $latest->details['roomCount'] ?? null,
        'roomsNearEachOther' => $latest->details['roomsNearEachOther'] ?? null,
        'roomsNearEachOtherCount' => $latest->details['roomsNearEachOtherCount'] ?? null,
        'checkInDate' => $latest->details['checkInDate'] ?? null,
        'checkOutDate' => $latest->details['checkOutDate'] ?? null,
        'roomType' => $latest->details['roomType'] ?? null,
        'bookingType' => $latest->details['bookingType'] ?? null,
    ];
    
    foreach ($selected as $key => $value) {
        $display = is_bool($value) ? ($value ? 'true' : 'false') : $value;
        echo "     {$key}: {$display}\n";
    }
}

echo "\n────────────────────────────────────────────────────────────────\n";
echo "\n✅ Verification complete!\n\n";
?>
