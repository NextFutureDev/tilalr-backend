<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IslandDestination;
use App\Models\City;

class IslandDestinationsSeeder extends Seeder
{
    public function run()
    {
        $internationals = [
            [
                'title_en' => 'Maldives Paradise Island',
                'title_ar' => 'جزيرة المالديف الفردوس',
                'description_en' => 'Experience luxury at its finest with crystal clear waters and pristine beaches.',
                'description_ar' => 'اختبر الفخامة بأفضل صورها مع المياه الصافية والشواطئ النقية.',
                'slug' => 'maldives-paradise',
                'price' => 2500.00,
                'rating' => 4.8,
                'type' => 'international',
                'image' => 'islands/maldives.jpg',
                'duration_en' => '7 Days',
                'duration_ar' => '٧ أيام',
                'groupSize_en' => '2-4 People',
                'groupSize_ar' => '٢-٤ أشخاص',
                'location_en' => 'Maldives',
                'location_ar' => 'المالديف',
                'features' => json_encode(['Water Sports', 'Spa & Wellness', 'Fine Dining', 'Snorkeling']),
                'active' => true,
            ],
            [
                'title_en' => 'Bali Island Escape',
                'title_ar' => 'رحلة جزيرة بالي',
                'description_en' => 'Discover the cultural richness and natural beauty of Bali with expert guides.',
                'description_ar' => 'اكتشف الثروة الثقافية والجمال الطبيعي لبالي مع الأدلاء الخبراء.',
                'slug' => 'bali-escape',
                'price' => 1800.00,
                'rating' => 4.7,
                'type' => 'international',
                'image' => 'islands/bali.jpg',
                'duration_en' => '5 Days',
                'duration_ar' => '٥ أيام',
                'groupSize_en' => '2-6 People',
                'groupSize_ar' => '٢-٦ أشخاص',
                'location_en' => 'Indonesia',
                'location_ar' => 'إندونيسيا',
                'features' => json_encode(['Temple Tours', 'Yoga Retreat', 'Beach Club', 'Cultural Immersion']),
                'active' => true,
            ],
            [
                'title_en' => 'Seychelles Luxury Retreat',
                'title_ar' => 'ملجأ سيشل الفاخر',
                'description_en' => 'An exclusive tropical paradise with white sand beaches and turquoise lagoons.',
                'description_ar' => 'جنة استوائية حصرية مع شواطئ رملية بيضاء وبحيرات فيروزية.',
                'slug' => 'seychelles-luxury',
                'price' => 3200.00,
                'rating' => 4.9,
                'type' => 'international',
                'image' => 'islands/seychelles.jpg',
                'duration_en' => '8 Days',
                'duration_ar' => '٨ أيام',
                'groupSize_en' => '2-4 People',
                'groupSize_ar' => '٢-٤ أشخاص',
                'location_en' => 'Seychelles',
                'location_ar' => 'سيشل',
                'features' => json_encode(['Diving', 'Private Beach', 'Sunset Cruises', 'Wildlife Tours']),
                'active' => true,
            ],
        ];

        foreach ($internationals as $data) {
            $attributes = ['slug' => $data['slug']];
            IslandDestination::updateOrCreate($attributes, $data);
        }
    }
}
