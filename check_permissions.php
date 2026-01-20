<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Role;
use App\Models\Permission;

echo "=== SUPER ADMIN ROLE PERMISSIONS ===\n\n";

$superAdminRole = Role::where('name', 'super_admin')->first();
echo "Role: {$superAdminRole->display_name}\n";
echo "Permissions count: " . $superAdminRole->permissions->count() . "\n\n";

// Group permissions by group
$permissions = Permission::orderBy('group')->orderBy('name')->get()->groupBy('group');

foreach ($permissions as $group => $perms) {
    echo "[$group]\n";
    foreach ($perms as $perm) {
        echo "  - {$perm->name}: {$perm->display_name}\n";
    }
    echo "\n";
}
