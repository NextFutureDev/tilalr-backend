<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Str;

$roleName = 'customer';
$displayName = 'Customer';

$desiredPermissions = [
    'view_bookings',
    'manage_bookings',
    'view_reservations',
    'manage_reservations',
    'view_contacts',
    'manage_contacts',
    'view_users',
    'manage_users',
];

echo "Ensuring permissions exist...\n";
$createdPerms = [];
foreach ($desiredPermissions as $p) {
    $perm = Permission::firstOrCreate([
        'name' => $p,
    ], [
        'display_name' => Str::title(str_replace('_', ' ', $p)),
        'description' => null,
    ]);
    $createdPerms[] = $perm->name;
}

echo "Creating or finding role '$roleName'...\n";
$role = Role::firstOrCreate([
    'name' => $roleName,
], [
    'display_name' => $displayName,
    'title_en' => $displayName,
    'title_ar' => $displayName,
    'is_active' => true,
]);

// Attach permissions (sync to ensure exact set)
$permsToSync = Permission::whereIn('name', $desiredPermissions)->pluck('id')->toArray();
$role->permissions()->sync($permsToSync);

echo "Role '{$role->name}' now has permissions: " . implode(', ', $role->permissions()->pluck('name')->toArray()) . "\n";

// Optionally create a test user and assign the role
$createTestUser = true; // set false if you don't want a test user
if ($createTestUser) {
    $email = 'customer@tilalr.com';
    $user = User::firstOrCreate([
        'email' => $email,
    ], [
        'name' => 'Customer User',
        'password' => bcrypt('password123'),
        'is_admin' => false,
    ]);

    // Sync the role to the user
    $user->roles()->syncWithoutDetaching([$role->id]);

    echo "Test user created/ensured: {$user->email} (id: {$user->id}). Assigned role '{$role->name}'.\n";
    echo "Login with that user and call GET /api/user to confirm roles & permissions are returned.\n";
}

echo "Done.\n";
