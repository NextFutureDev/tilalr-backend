<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

echo "=== ROLES -> PERMISSIONS ===\n\n";
$roles = Role::with('permissions')->orderBy('name')->get();
foreach ($roles as $role) {
    echo "Role: {$role->name} ({$role->display_name})\n";
    $perms = $role->permissions->pluck('name')->toArray();
    if (empty($perms)) {
        echo "  (no permissions)\n";
    } else {
        foreach ($perms as $p) {
            echo "  - $p\n";
        }
    }
    echo "\n";
}

echo "=== USERS -> ROLES -> PERMISSIONS ===\n\n";
$users = User::with('roles.permissions')->orderBy('email')->get();
foreach ($users as $u) {
    echo "User: {$u->email} (id: {$u->id})\n";
    $roles = $u->roles->pluck('name')->toArray();
    echo "  Roles: " . (empty($roles) ? '(none)' : implode(', ', $roles)) . "\n";
    $permissions = $u->roles->flatMap(fn($r) => $r->permissions->pluck('name'))->unique()->values()->toArray();
    echo "  Permissions: " . (empty($permissions) ? '(none)' : implode(', ', $permissions)) . "\n";
    echo "\n";
}

echo "Done. Use this script to verify role/permission mappings and to confirm a user's effective permissions.\n";