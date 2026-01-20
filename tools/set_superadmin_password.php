<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

$email = 'superadmin@tilalr.com';
$newPassword = 'superadmin123';
$user = User::where('email', $email)->first();
if (!$user) {
    echo "User not found\n";
    exit(1);
}
$user->password = Hash::make($newPassword);
$user->save();

echo "Updated password for {$email}\n";
