<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Role;
use App\Models\Permission;

echo "=== RBAC VERIFICATION ===\n\n";

echo "ROLES:\n";
$roles = Role::all();
foreach ($roles as $role) {
    echo "  ✓ {$role->name} ({$role->display_name})\n";
    echo "    Permissions: " . $role->permissions()->count() . "\n";
}

echo "\nPERMISSIONS: " . Permission::count() . " total\n";

echo "\nROLE-PERMISSION MAPPINGS:\n";
foreach ($roles as $role) {
    $perms = $role->permissions()->pluck('name')->toArray();
    echo "  {$role->name}: " . count($perms) . " permissions\n";
    if (count($perms) <= 5) {
        foreach ($perms as $perm) {
            echo "    - $perm\n";
        }
    } else {
        for ($i = 0; $i < 3; $i++) {
            echo "    - {$perms[$i]}\n";
        }
        echo "    ... and " . (count($perms) - 3) . " more\n";
    }
}

echo "\n✅ RBAC database setup complete!\n";
