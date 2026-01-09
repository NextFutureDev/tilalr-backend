<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define all permissions
        $permissions = [
            // International Destinations
            ['name' => 'view_international_destinations', 'display_name' => 'View International Destinations'],
            ['name' => 'create_international_destinations', 'display_name' => 'Create International Destinations'],
            ['name' => 'edit_international_destinations', 'display_name' => 'Edit International Destinations'],
            ['name' => 'delete_international_destinations', 'display_name' => 'Delete International Destinations'],
            
            // International Flights
            ['name' => 'view_international_flights', 'display_name' => 'View International Flights'],
            ['name' => 'create_international_flights', 'display_name' => 'Create International Flights'],
            ['name' => 'edit_international_flights', 'display_name' => 'Edit International Flights'],
            ['name' => 'delete_international_flights', 'display_name' => 'Delete International Flights'],
            
            // International Hotels
            ['name' => 'view_international_hotels', 'display_name' => 'View International Hotels'],
            ['name' => 'create_international_hotels', 'display_name' => 'Create International Hotels'],
            ['name' => 'edit_international_hotels', 'display_name' => 'Edit International Hotels'],
            ['name' => 'delete_international_hotels', 'display_name' => 'Delete International Hotels'],
            
            // International Packages
            ['name' => 'view_international_packages', 'display_name' => 'View International Packages'],
            ['name' => 'create_international_packages', 'display_name' => 'Create International Packages'],
            ['name' => 'edit_international_packages', 'display_name' => 'Edit International Packages'],
            ['name' => 'delete_international_packages', 'display_name' => 'Delete International Packages'],
            
            // Island Destinations
            ['name' => 'view_island_destinations', 'display_name' => 'View Island Destinations'],
            ['name' => 'create_island_destinations', 'display_name' => 'Create Island Destinations'],
            ['name' => 'edit_island_destinations', 'display_name' => 'Edit Island Destinations'],
            ['name' => 'delete_island_destinations', 'display_name' => 'Delete Island Destinations'],
            
            // Offers
            ['name' => 'view_offers', 'display_name' => 'View Offers'],
            ['name' => 'create_offers', 'display_name' => 'Create Offers'],
            ['name' => 'edit_offers', 'display_name' => 'Edit Offers'],
            ['name' => 'delete_offers', 'display_name' => 'Delete Offers'],
            
            // Services
            ['name' => 'view_services', 'display_name' => 'View Services'],
            ['name' => 'create_services', 'display_name' => 'Create Services'],
            ['name' => 'edit_services', 'display_name' => 'Edit Services'],
            ['name' => 'delete_services', 'display_name' => 'Delete Services'],
            
            // Trips
            ['name' => 'view_trips', 'display_name' => 'View Trips'],
            ['name' => 'create_trips', 'display_name' => 'Create Trips'],
            ['name' => 'edit_trips', 'display_name' => 'Edit Trips'],
            ['name' => 'delete_trips', 'display_name' => 'Delete Trips'],
            
            // Contacts
            ['name' => 'view_contacts', 'display_name' => 'View Contacts'],
            ['name' => 'manage_contacts', 'display_name' => 'Manage Contacts'],
            
            // Reservations & Bookings
            ['name' => 'view_reservations', 'display_name' => 'View Reservations'],
            ['name' => 'manage_reservations', 'display_name' => 'Manage Reservations'],
            ['name' => 'view_bookings', 'display_name' => 'View Bookings'],
            ['name' => 'manage_bookings', 'display_name' => 'Manage Bookings'],
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['display_name' => $permission['display_name']]
            );
        }

        // Define roles
        $roles = [
            [
                'name' => 'executive_manager',
                'title_en' => 'Executive Manager',
                'title_ar' => 'مدير تنفيذي',
                'display_name' => 'Executive Manager',
                'description' => 'Full access to all international and island destinations, flights, hotels, packages, contacts, reservations and bookings',
                'permissions' => [
                    'view_international_destinations', 'create_international_destinations', 'edit_international_destinations', 'delete_international_destinations',
                    'view_international_flights', 'create_international_flights', 'edit_international_flights', 'delete_international_flights',
                    'view_international_hotels', 'create_international_hotels', 'edit_international_hotels', 'delete_international_hotels',
                    'view_international_packages', 'create_international_packages', 'edit_international_packages', 'delete_international_packages',
                    'view_island_destinations', 'create_island_destinations', 'edit_island_destinations', 'delete_island_destinations',
                    'view_contacts', 'manage_contacts',
                    'view_reservations', 'manage_reservations',
                    'view_bookings', 'manage_bookings',
                ]
            ],
            [
                'name' => 'consultant',
                'title_en' => 'Consultant',
                'title_ar' => 'استشاري',
                'display_name' => 'Consultant',
                'description' => 'Access to island destinations, offers, services, trips, contacts, reservations and bookings',
                'permissions' => [
                    'view_island_destinations', 'create_island_destinations', 'edit_island_destinations', 'delete_island_destinations',
                    'view_offers', 'create_offers', 'edit_offers', 'delete_offers',
                    'view_services', 'create_services', 'edit_services', 'delete_services',
                    'view_trips', 'create_trips', 'edit_trips', 'delete_trips',
                    'view_contacts', 'manage_contacts',
                    'view_reservations', 'manage_reservations',
                    'view_bookings', 'manage_bookings',
                ]
            ],
            [
                'name' => 'administration',
                'title_en' => 'Administration',
                'title_ar' => 'إدارة',
                'display_name' => 'Administration',
                'description' => 'Access only to communications management',
                'permissions' => [
                    'view_contacts', 'manage_contacts',
                ]
            ],
            [
                'name' => 'super_admin',
                'title_en' => 'Super Admin',
                'title_ar' => 'مسؤول فائق',
                'display_name' => 'Super Admin',
                'description' => 'Full access to all resources and settings',
                'permissions' => 'all' // Special marker for all permissions
            ],
        ];

        // Create roles with permissions
        foreach ($roles as $roleData) {
            $permissions = $roleData['permissions'];
            unset($roleData['permissions']);

            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );

            // Attach permissions to role
            if ($permissions === 'all') {
                // Super Admin gets all permissions
                $allPermissions = Permission::pluck('id')->toArray();
                $role->permissions()->sync($allPermissions);
            } else {
                // Other roles get specific permissions
                $permissionIds = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
                $role->permissions()->sync($permissionIds);
            }
        }

        echo "✅ Roles and Permissions seeded successfully!\n";
        foreach ($roles as $role) {
            echo "   Role: {$role['display_name']}\n";
        }
    }
}
