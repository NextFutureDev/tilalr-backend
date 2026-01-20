<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'superadmin@tilalr.com')->first();
if (!$user) {
    echo "Superadmin not found\n";
    exit(1);
}

$candidatePasswords = [
    'superadmin123',
    'password123',
    'password',
    'superadmin',
];

foreach ($candidatePasswords as $pwd) {
    if (Hash::check($pwd, $user->password)) {
        echo "Password match found: {$pwd}\n";
        exit(0);
    }
}

echo "No candidate passwords matched the superadmin hash.\n";
return 0;
