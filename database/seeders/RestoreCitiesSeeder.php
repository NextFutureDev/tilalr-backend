<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RestoreCitiesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Insert two cities with stable IDs (auto-increment), which should yield ids 1 and 2
        DB::table('cities')->insert([
            [
                'name' => 'الرياض',
                'slug' => 'riyadh',
                'description' => 'عاصمة المملكة العربية السعودية',
                'country' => 'Saudi Arabia',
                'order' => 1,
                'lang' => 'ar',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'جدة',
                'slug' => 'jeddah',
                'description' => 'عروس البحر الأحمر',
                'country' => 'Saudi Arabia',
                'order' => 2,
                'lang' => 'ar',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
