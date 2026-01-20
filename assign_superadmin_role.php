<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;

// Get the superadmin user
$user = User::where('email', 'superadmin@tilalr.com')->first();
$superAdminRole = Role::where('name', 'super_admin')->first();

if (!$user) {
    echo "ERROR: User not found!\n";
    exit(1);
}

if (!$superAdminRole) {
    echo "ERROR: super_admin role not found!\n";
    exit(1);
}

// Assign the role
$user->roles()->sync([$superAdminRole->id]);

echo "SUCCESS: Assigned 'super_admin' role to {$user->email}\n";

// Verify
$user->refresh();
echo "User now has roles: " . $user->roles->pluck('name')->join(', ') . "\n";
