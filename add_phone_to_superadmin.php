<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'superadmin@tilalr.com')->first();
$user->phone = '+966501234567';
$user->save();

echo "Phone added to superadmin: {$user->phone}\n";
echo "User updated successfully!\n";