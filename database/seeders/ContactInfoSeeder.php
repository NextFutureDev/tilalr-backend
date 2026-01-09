<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert a minimal contact info record if table exists
        if (\Schema::hasTable('contact_infos')) {
            DB::table('contact_infos')->updateOrInsert(
                ['type' => 'general'],
                [
                    'title' => json_encode(['en' => 'Contact Us', 'ar' => 'اتصل بنا']),
                    'content' => json_encode(['en' => 'Phone: +966-500-000-000\nEmail: info@example.com', 'ar' => 'الهاتف: +966-500-000-000\nالبريد: info@example.com']),
                    'icon' => 'bi-telephone',
                    'working_hours' => 'Sun-Thu 9:00-17:00',
                    'sort_order' => 0,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
