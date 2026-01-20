<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeroSection;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSection::create([
            'headline_en' => 'Innovative Environmental & Geological & Geophysical and meteorological Solutions',
            'headline_ar' => 'حلول بيئية وجيولوجية وجيوفيزيائية وأرصاد جوية مبتكرة',
            'paragraph_en' => 'Accurate insights with the latest geological & geophysical techniques.',
            'paragraph_ar' => 'تقديم رؤى دقيقة لمشاريعك',
            'linkedin_url' => 'https://linkedin.com/company/sensing-nature',
            'twitter_url' => 'https://x.com/sensingnature',
            'facebook_url' => 'https://facebook.com/sensingnature',
            'instagram_url' => 'https://instagram.com/sensingnature',
            'snapchat_url' => 'https://snapchat.com/add/sensingnature',
            'tiktok_url' => 'https://tiktok.com/@sensingnature',
            'is_active' => true,
        ]);
    }
}
