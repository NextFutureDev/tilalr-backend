<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Checking Reservations ===\n\n";

// Check reservations table exists
$reservations = \App\Models\Reservation::all();
echo "Total Reservations in DB: " . count($reservations) . "\n";

if (count($reservations) > 0) {
    echo "\nReservation Details:\n";
    echo "-------------------\n";
    foreach ($reservations as $r) {
        echo "ID: {$r->id}\n";
        echo "Email: {$r->email}\n";
        echo "Name: {$r->name}\n";
        echo "Phone: {$r->phone}\n";
        echo "Status: {$r->status}\n";
        echo "Trip Type: {$r->trip_type}\n";
        echo "Created: {$r->created_at}\n";
        echo "---\n";
    }
} else {
    echo "❌ NO RESERVATIONS IN DATABASE!\n";
}

echo "\n=== Checking Bookings ===\n\n";
$bookings = \App\Models\Booking::all();
echo "Total Bookings in DB: " . count($bookings) . "\n";

echo "\n=== Checking Users ===\n\n";
$users = \App\Models\User::all();
echo "Total Users in DB: " . count($users) . "\n";
foreach ($users as $u) {
    echo "ID: {$u->id}, Email: {$u->email}, Name: {$u->name}\n";
}
