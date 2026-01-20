<?php
// Check user phone formats in database
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = \App\Models\User::select('id', 'name', 'phone', 'email')->limit(15)->get();

echo "=== Users Phone Formats ===\n";
foreach ($users as $u) {
    echo sprintf("ID: %d | Phone: %-20s | Email: %s\n", $u->id, $u->phone ?? 'NULL', $u->email);
}

// Test findUserByPhone with REAL phones from database
echo "\n=== Testing Phone Lookup with REAL phones ===\n";
$testPhones = ['0551981712', '0550000000', '0551981753', '+966501234567'];
$otpService = app(\App\Services\OtpService::class);

foreach ($testPhones as $phone) {
    $user = $otpService->findUserByPhone($phone);
    echo sprintf("Lookup '%s' => %s\n", $phone, $user ? "User ID: {$user->id} ({$user->email})" : "NOT FOUND");
}
