<?php

namespace Database\Seeders;

use App\Models\IslandDestination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IslandDestinationsInternationalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'title_en' => 'Maldives Paradise Island',
                'title_ar' => 'جزيرة المالديف الفردوس',
                'type' => 'international',
                'type_en' => 'Tropical Resort',
                'type_ar' => 'منتجع استوائي',
                'description_en' => 'Experience luxury at its finest with crystal clear waters and pristine beaches.',
                'description_ar' => 'اختبر الفخامة بأفضل صورها مع المياه الصافية والشواطئ النقية.',
                'location_en' => 'Maldives',
                'location_ar' => 'المالديف',
                'duration_en' => '7 Days',
                'duration_ar' => '٧ أيام',
                'groupSize_en' => '2-4 People',
                'groupSize_ar' => '٢-٤ أشخاص',
                'price' => '2500',
                'rating' => 4.8,
                'image' => 'maldives.jpg',
                'features_en' => json_encode(['Water Sports', 'Spa & Wellness', 'Fine Dining', 'Snorkeling']),
                'features_ar' => json_encode(['ألعاب مائية', 'سبا وعافية', 'تناول طعام فاخر', 'الغطس بالأنابيب']),
                'slug' => 'maldives-paradise',
                'active' => true,
            ],
            [
                'title_en' => 'Bali Island Escape',
                'title_ar' => 'رحلة جزيرة بالي',
                'type' => 'international',
                'type_en' => 'Cultural Island',
                'type_ar' => 'جزيرة ثقافية',
                'description_en' => 'Discover the cultural richness and natural beauty of Bali with expert guides.',
                'description_ar' => 'اكتشف الثروة الثقافية والجمال الطبيعي لبالي مع الأدلاء الخبراء.',
                'location_en' => 'Indonesia',
                'location_ar' => 'إندونيسيا',
                'duration_en' => '5 Days',
                'duration_ar' => '٥ أيام',
                'groupSize_en' => '2-6 People',
                'groupSize_ar' => '٢-٦ أشخاص',
                'price' => '1800',
                'rating' => 4.7,
                'image' => 'bali.jpg',
                'features_en' => json_encode(['Temple Tours', 'Yoga Retreat', 'Beach Club', 'Cultural Immersion']),
                'features_ar' => json_encode(['جولات معابد', 'انسحاب يوجا', 'ناد شاطئي', 'الانغماس الثقافي']),
                'slug' => 'bali-escape',
                'active' => true,
            ],
            [
                'title_en' => 'Seychelles Luxury Retreat',
                'title_ar' => 'ملجأ سيشل الفاخر',
                'type' => 'international',
                'type_en' => 'Luxury Paradise',
                'type_ar' => 'جنة فاخرة',
                'description_en' => 'An exclusive tropical paradise with white sand beaches and turquoise lagoons.',
                'description_ar' => 'جنة استوائية حصرية مع شواطئ رملية بيضاء وبحيرات فيروزية.',
                'location_en' => 'Seychelles',
                'location_ar' => 'سيشل',
                'duration_en' => '8 Days',
                'duration_ar' => '٨ أيام',
                'groupSize_en' => '2-4 People',
                'groupSize_ar' => '٢-٤ أشخاص',
                'price' => '3200',
                'rating' => 4.9,
                'image' => 'seychelles.jpg',
                'features_en' => json_encode(['Diving', 'Private Beach', 'Sunset Cruises', 'Wildlife Tours']),
                'features_ar' => json_encode(['الغوص', 'شاطئ خاص', 'رحلات الغروب', 'جولات الحياة البرية']),
                'slug' => 'seychelles-luxury',
                'active' => true,
            ],
        ];

        foreach ($destinations as $destination) {
            IslandDestination::updateOrCreate(
                ['slug' => $destination['slug']],
                $destination
            );
        }
    }
}
