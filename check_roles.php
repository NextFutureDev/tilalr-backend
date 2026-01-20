<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;

echo "=== ALL ROLES ===\n";
$roles = Role::all();
foreach ($roles as $role) {
    echo "- {$role->name} (id: {$role->id})\n";
}

echo "\n=== SUPERADMIN USER ===\n";
$user = User::where('email', 'superadmin@tilalr.com')->first();
if ($user) {
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Roles: " . $user->roles->pluck('name')->join(', ') . "\n";
    echo "\nHas super_admin role: " . ($user->hasRole('super_admin') ? 'YES' : 'NO') . "\n";
    echo "Has consultant role: " . ($user->hasRole('consultant') ? 'YES' : 'NO') . "\n";
} else {
    echo "User not found!\n";
}

echo "\n=== ALL USERS WITH ROLES ===\n";
$users = User::with('roles')->get();
foreach ($users as $u) {
    echo "{$u->email}: " . $u->roles->pluck('name')->join(', ') . "\n";
}
