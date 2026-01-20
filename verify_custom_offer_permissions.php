<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Permission;
use App\Models\Role;

echo "\n=== CUSTOM PAYMENT OFFER PERMISSIONS ===\n";
$permissions = Permission::where('group', 'Payments')->orderBy('name')->get();
foreach ($permissions as $p) {
    echo "✓ {$p->display_name} ({$p->name})\n";
}

echo "\n=== ROLE PERMISSION MAPPING ===\n";
$superAdmin = Role::where('name', 'super_admin')->first();
if ($superAdmin) {
    echo "\nSuper Admin Role Permissions:\n";
    $superAdminPerms = $superAdmin->permissions()->where('group', 'Payments')->get();
    foreach ($superAdminPerms as $perm) {
        echo "  ✓ {$perm->display_name}\n";
    }
} else {
    echo "⚠ Super Admin role not found\n";
}

echo "\n";
