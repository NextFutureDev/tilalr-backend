<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define all resources and their display names
        $resources = [
            // Users
            'users' => 'Users',
            
            // Content
            'trips' => 'Trips',
            'offers' => 'Offers',
            'services' => 'Services',
            
            // Destinations
            'island_destinations' => 'Local Islands',
            'international_islands' => 'International Islands',
            
            // International
            'international_destinations' => 'International Destinations',
            'international_flights' => 'International Flights',
            'international_hotels' => 'International Hotels',
            'international_packages' => 'International Packages',
            
            // Reservations & Bookings
            'reservations' => 'Reservations',
            'bookings' => 'Bookings',
            'payments' => 'Payments',
            
            // Communication
            'contacts' => 'Contacts',
            
            // Settings
            'cities' => 'Cities',
            'settings' => 'Settings',
        ];

        // Actions for each resource
        $actions = [
            'view_any' => 'View All',
            'view' => 'View',
            'create' => 'Create',
            'update' => 'Update',
            'delete' => 'Delete',
        ];

        // Create permissions for each resource
        foreach ($resources as $resourceKey => $displayName) {
            foreach ($actions as $actionKey => $actionDisplay) {
                Permission::firstOrCreate(
                    ['name' => "{$resourceKey}.{$actionKey}"],
                    [
                        'display_name' => "{$actionDisplay} {$displayName}",
                        'group' => $displayName,
                        'description' => "Allows user to {$actionDisplay} {$displayName}",
                    ]
                );
            }
        }

        // Add special permissions
        $specialPermissions = [
            ['name' => 'dashboard.view', 'display_name' => 'View Dashboard', 'group' => 'Dashboard', 'description' => 'Access to the admin dashboard'],
            ['name' => 'reports.view', 'display_name' => 'View Reports', 'group' => 'Reports', 'description' => 'Access to view reports'],
            ['name' => 'reports.export', 'display_name' => 'Export Reports', 'group' => 'Reports', 'description' => 'Export reports to PDF/Excel'],
        ];

        foreach ($specialPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']], $perm);
        }

        $this->command->info('Permissions seeded successfully!');
        $this->command->info('Total permissions: ' . Permission::count());

        // Now assign all permissions to super_admin role
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $allPermissions = Permission::pluck('id')->toArray();
            $superAdminRole->permissions()->sync($allPermissions);
            $this->command->info('All permissions assigned to Super Admin role.');
        }

        // Update role display names if not set
        $roleDisplayNames = [
            'super_admin' => 'Super Admin',
            'executive_manager' => 'Executive Manager',
            'consultant' => 'Consultant',
            'administration' => 'Administration',
            'customer' => 'Customer',
            'content_manager' => 'Content Manager',
            'support_agent' => 'Support Agent',
            'data_analyst' => 'Data Analyst',
        ];

        foreach ($roleDisplayNames as $name => $displayName) {
            Role::where('name', $name)->update(['display_name' => $displayName]);
        }
        $this->command->info('Role display names updated.');
    }
}
