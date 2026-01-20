<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== API LOGIN TEST ===\n\n";

// Test user credentials
$email = 'superadmin@tilalr.com';
$password = '439c0912efaa4ebf';

echo "Testing credentials:\n";
echo "Email: $email\n";
echo "Password: $password\n\n";

// Find user
$user = User::where('email', $email)->first();
if (!$user) {
    echo "ERROR: User not found with email $email\n";
    exit(1);
}

echo "User found:\n";
echo "ID: {$user->id}\n";
echo "Name: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Phone: " . ($user->phone ?? 'NULL') . "\n";
echo "is_admin: " . ($user->is_admin ? 'true' : 'false') . "\n";
echo "Roles: " . $user->roles->pluck('name')->join(', ') . "\n\n";

// Test password
$passwordCheck = Hash::check($password, $user->password);
echo "Password check: " . ($passwordCheck ? 'PASS' : 'FAIL') . "\n";

if (!$passwordCheck) {
    echo "ERROR: Password does not match!\n";
    echo "Stored hash: {$user->password}\n";
    exit(1);
}

echo "\n=== ISSUES FOUND ===\n";

if (!$user->phone) {
    echo "ISSUE: User has no phone number. API login requires phone or email.\n";
    echo "SOLUTION: Add phone number or modify API to handle email-only users.\n";
}

echo "\n=== API LOGIN SIMULATION ===\n";

// Simulate the API login process
if ($user->is_admin) {
    echo "User is admin - should get token directly without OTP\n";
    try {
        $token = $user->createToken('auth-token')->plainTextToken;
        echo "Token generated successfully: " . substr($token, 0, 20) . "...\n";
        
        $user->load('roles.permissions');
        $permissions = $user->roles->flatMap(fn($role) => $role->permissions->pluck('name'))->unique()->values();
        
        echo "Roles: " . $user->roles->pluck('name')->join(', ') . "\n";
        echo "Permissions count: " . $permissions->count() . "\n";
        
    } catch (Exception $e) {
        echo "ERROR generating token: " . $e->getMessage() . "\n";
    }
}