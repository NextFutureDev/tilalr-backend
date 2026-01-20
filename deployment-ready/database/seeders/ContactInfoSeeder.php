<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactInfos = [
            [
                'type' => 'location',
                'title' => [
                    'en' => 'Our Location',
                    'ar' => 'موقعنا'
                ],
                'content' => [
                    'en' => "123 Business Street\nCity, State 12345",
                    'ar' => "123 شارع الأعمال\nالمدينة، الولاية 12345"
                ],
                'icon' => 'bi-geo-alt',
                'working_hours' => null,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'type' => 'phone',
                'title' => [
                    'en' => 'Phone Number',
                    'ar' => 'رقم الهاتف'
                ],
                'content' => [
                    'en' => '+20 01068775968',
                    'ar' => '+20 01068775968'
                ],
                'icon' => 'bi-telephone',
                'working_hours' => 'Mon-Fri 9AM-6PM',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'type' => 'email',
                'title' => [
                    'en' => 'Email Address',
                    'ar' => 'عنوان البريد الإلكتروني'
                ],
                'content' => [
                    'en' => "info@company.com\nsupport@company.com",
                    'ar' => "info@company.com\nsupport@company.com"
                ],
                'icon' => 'bi-envelope',
                'working_hours' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($contactInfos as $contactInfo) {
            ContactInfo::create($contactInfo);
        }
    }
}
