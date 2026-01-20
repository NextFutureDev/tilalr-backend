<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class CreateCustomPaymentOfferPermissionsSeeder extends Seeder
{
    /**
     * Create permissions for Custom Payment Offers and assign to roles
     */
    public function run(): void
    {
        // Define custom payment offer permissions
        $permissions = [
            [
                'name' => 'custom_payment_offers.view',
                'display_name' => 'View Custom Payment Offers',
                'description' => 'View list of custom payment offers',
                'group' => 'Payments',
            ],
            [
                'name' => 'custom_payment_offers.create',
                'display_name' => 'Create Custom Payment Offers',
                'description' => 'Create new custom payment offers',
                'group' => 'Payments',
            ],
            [
                'name' => 'custom_payment_offers.edit',
                'display_name' => 'Edit Custom Payment Offers',
                'description' => 'Edit existing custom payment offers',
                'group' => 'Payments',
            ],
            [
                'name' => 'custom_payment_offers.delete',
                'display_name' => 'Delete Custom Payment Offers',
                'description' => 'Delete custom payment offers',
                'group' => 'Payments',
            ],
            [
                'name' => 'custom_payment_offers.view_payment_link',
                'display_name' => 'View Payment Links',
                'description' => 'View and copy unique payment links for offers',
                'group' => 'Payments',
            ],
            [
                'name' => 'custom_payment_offers.manage_payments',
                'display_name' => 'Manage Payments',
                'description' => 'View payment status and transaction details',
                'group' => 'Payments',
            ],
        ];

        // Create or update permissions
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description'],
                    'group' => $permission['group'],
                ]
            );
            echo "✓ Permission created/updated: {$permission['display_name']}\n";
        }

        // Assign all permissions to super_admin role automatically
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $permissionIds = Permission::where('group', 'Payments')->pluck('id')->toArray();
            $superAdminRole->permissions()->syncWithoutDetaching($permissionIds);
            echo "\n✓ All Payments permissions assigned to Super Admin role\n";
        } else {
            echo "\n⚠ Super Admin role not found. Please create it first.\n";
        }
    }
}
