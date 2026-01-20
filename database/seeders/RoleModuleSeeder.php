<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleModuleSeeder extends Seeder
{
    public function run(): void
    {
        // Define all available modules
        $modules = [
            'Dashboard',
            'Payments',
            'Users',
            'Website Settings',
            'Settings',
            'International',
            'International Destinations',
            'International Flights',
            'International Hotels',
            'International Packages',
            'Destinations',
            'Island Destinations',
            'Content',
            'Offers',
            'Services',
            'Trips',
            'Communication',
            'Contacts',
            'Reservations & Bookings',
            'Reservations',
            'Bookings',
        ];

        // Predefined roles with module access
        $roles = [
            [
                'name' => 'super_admin',
                'title_en' => 'Super Admin',
                'title_ar' => 'مدير سوبر',
                'description_en' => 'Full access to all modules',
                'description_ar' => 'وصول كامل إلى جميع الوحدات',
                'is_active' => true,
                'sort_order' => 1,
                'allowed_modules' => $modules, // Super Admin has access to all
            ],
            [
                'name' => 'executive_manager',
                'title_en' => 'Executive Manager',
                'title_ar' => 'مدير تنفيذي',
                'description_en' => 'Manages reservations, bookings, and international content',
                'description_ar' => 'يدير الحجوزات والدفوعات والمحتوى الدولي',
                'is_active' => true,
                'sort_order' => 2,
                'allowed_modules' => [
                    'Dashboard',
                    'Reservations & Bookings',
                    'Reservations',
                    'Bookings',
                    'Payments',
                    'International',
                    'International Destinations',
                    'International Flights',
                    'International Hotels',
                    'International Packages',
                    'Contacts',
                ],
            ],
            [
                'name' => 'consultant',
                'title_en' => 'Consultant',
                'title_ar' => 'مستشار',
                'description_en' => 'Manages content and offerings',
                'description_ar' => 'يدير المحتوى والعروض',
                'is_active' => true,
                'sort_order' => 3,
                'allowed_modules' => [
                    'Dashboard',
                    'Content',
                    'Offers',
                    'Services',
                    'Trips',
                    'Destinations',
                    'Island Destinations',
                    'Contacts',
                ],
            ],
            [
                'name' => 'content_manager',
                'title_en' => 'Content Manager',
                'title_ar' => 'مدير المحتوى',
                'description_en' => 'Manages website content and settings',
                'description_ar' => 'يدير محتوى الموقع والإعدادات',
                'is_active' => true,
                'sort_order' => 4,
                'allowed_modules' => [
                    'Dashboard',
                    'Content',
                    'Offers',
                    'Services',
                    'Trips',
                    'Website Settings',
                    'Settings',
                ],
            ],
            [
                'name' => 'support_agent',
                'title_en' => 'Support Agent',
                'title_ar' => 'وكيل الدعم',
                'description_en' => 'Handles customer inquiries and reservations',
                'description_ar' => 'يتعامل مع استفسارات العملاء والحجوزات',
                'is_active' => true,
                'sort_order' => 5,
                'allowed_modules' => [
                    'Dashboard',
                    'Reservations & Bookings',
                    'Reservations',
                    'Bookings',
                    'Contacts',
                ],
            ],
            [
                'name' => 'data_analyst',
                'title_en' => 'Data Analyst',
                'title_ar' => 'محلل البيانات',
                'description_en' => 'View-only access to analytics and reports',
                'description_ar' => 'وصول للعرض فقط للتحليلات والتقارير',
                'is_active' => true,
                'sort_order' => 6,
                'allowed_modules' => [
                    'Dashboard',
                    'Payments',
                    'Reservations & Bookings',
                    'Reservations',
                    'Bookings',
                ],
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );
        }
    }
}
