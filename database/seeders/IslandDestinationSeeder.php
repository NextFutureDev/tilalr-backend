<?php

namespace Database\Seeders;

use App\Models\IslandDestination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IslandDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Single seeder that handles both local and international destinations
     * based on the 'type' field condition.
     */
    public function run(): void
    {
        // Define all destinations with their type condition
        $destinations = [
            // LOCAL DESTINATIONS (type = 'local')
            [
                'type' => 'local',
                'title_en' => 'Local island near Farasan',
                'title_ar' => 'جزيرة محلية بالقرب من فرسان',
                'description_en' => 'A beautiful local island near Farasan.',
                'description_ar' => 'وجهة جزيرة محلية بالقرب من فرسان.',
                'location_en' => 'Farasan, Saudi Arabia',
                'location_ar' => 'فرسان، المملكة العربية السعودية',
                'duration_en' => '3-4 Days',
                'duration_ar' => '3-4 أيام',
                'groupSize_en' => '2-6 People',
                'groupSize_ar' => '2-6 أشخاص',
                'features_en' => json_encode(['Swimming', 'Snorkeling', 'Beach BBQ']),
                'features_ar' => json_encode(['السباحة', 'الغطس بالأنابيب', 'حفلة شواء الشاطئ']),
                'image' => 'islands/local-farasan.jpg',
                'price' => 99.00,
                'rating' => 4.2,
                'slug' => 'local-island-farasan',
                'active' => true,
            ],
            [
                'type' => 'local',
                'title_en' => 'Local island near Umluj',
                'title_ar' => 'جزيرة محلية بالقرب من أملج',
                'description_en' => 'A beautiful local island near Umluj.',
                'description_ar' => 'وجهة جزيرة محلية بالقرب من أملج.',
                'location_en' => 'Umluj, Saudi Arabia',
                'location_ar' => 'أملج، المملكة العربية السعودية',
                'duration_en' => '2-3 Days',
                'duration_ar' => '2-3 أيام',
                'groupSize_en' => '2-4 People',
                'groupSize_ar' => '2-4 أشخاص',
                'features_en' => json_encode(['Diving', 'Photography', 'Relaxation']),
                'features_ar' => json_encode(['الغوص', 'التصوير الفوتوغرافي', 'الاسترخاء']),
                'image' => 'islands/local-umluj.jpg',
                'price' => 99.00,
                'rating' => 4.3,
                'slug' => 'local-island-umluj',
                'active' => true,
            ],
            [
                'type' => 'local',
                'title_en' => 'Local island near Al Lith',
                'title_ar' => 'جزيرة محلية بالقرب من الليث',
                'description_en' => 'A beautiful local island near Al Lith.',
                'description_ar' => 'وجهة جزيرة محلية بالقرب من الليث.',
                'location_en' => 'Al Lith, Saudi Arabia',
                'location_ar' => 'الليث، المملكة العربية السعودية',
                'duration_en' => '2-3 Days',
                'duration_ar' => '2-3 أيام',
                'groupSize_en' => '2-5 People',
                'groupSize_ar' => '2-5 أشخاص',
                'features_en' => json_encode(['Fishing', 'Beach', 'Water Sports']),
                'features_ar' => json_encode(['صيد السمك', 'الشاطئ', 'الرياضات المائية']),
                'image' => 'islands/local-al-lith.jpg',
                'price' => 99.00,
                'rating' => 4.1,
                'slug' => 'local-island-al-lith',
                'active' => true,
            ],

            // INTERNATIONAL DESTINATIONS (type = 'international')
            [
                'type' => 'international',
                'title_en' => 'Maldives Paradise Island',
                'title_ar' => 'جزيرة المالديف الفردوس',
                'description_en' => 'Experience luxury at its finest with crystal clear waters and pristine beaches.',
                'description_ar' => 'اختبر الفخامة بأفضل صورها مع المياه الصافية والشواطئ النقية.',
                'location_en' => 'Maldives',
                'location_ar' => 'المالديف',
                'duration_en' => '7 Days',
                'duration_ar' => '٧ أيام',
                'groupSize_en' => '2-4 People',
                'groupSize_ar' => '٢-٤ أشخاص',
                'features_en' => json_encode(['Water Sports', 'Spa & Wellness', 'Fine Dining', 'Snorkeling']),
                'features_ar' => json_encode(['ألعاب مائية', 'سبا وعافية', 'تناول طعام فاخر', 'الغطس بالأنابيب']),
                'image' => 'islands/maldives.jpg',
                'price' => 2500.00,
                'rating' => 4.8,
                'slug' => 'maldives-paradise',
                'active' => true,
            ],
            [
                'type' => 'international',
                'title_en' => 'Bali Island Escape',
                'title_ar' => 'رحلة جزيرة بالي',
                'description_en' => 'Discover the cultural richness and natural beauty of Bali with expert guides.',
                'description_ar' => 'اكتشف الثروة الثقافية والجمال الطبيعي لبالي مع الأدلاء الخبراء.',
                'location_en' => 'Indonesia',
                'location_ar' => 'إندونيسيا',
                'duration_en' => '5 Days',
                'duration_ar' => '٥ أيام',
                'groupSize_en' => '2-6 People',
                'groupSize_ar' => '٢-٦ أشخاص',
                'features_en' => json_encode(['Temple Tours', 'Yoga Retreat', 'Beach Club', 'Cultural Immersion']),
                'features_ar' => json_encode(['جولات معابد', 'انسحاب يوجا', 'ناد شاطئي', 'الانغماس الثقافي']),
                'image' => 'islands/bali.jpg',
                'price' => 1800.00,
                'rating' => 4.7,
                'slug' => 'bali-escape',
                'active' => true,
            ],
            [
                'type' => 'international',
                'title_en' => 'Seychelles Luxury Retreat',
                'title_ar' => 'ملجأ سيشل الفاخر',
                'description_en' => 'An exclusive tropical paradise with white sand beaches and turquoise lagoons.',
                'description_ar' => 'جنة استوائية حصرية مع شواطئ رملية بيضاء وبحيرات فيروزية.',
                'location_en' => 'Seychelles',
                'location_ar' => 'سيشل',
                'duration_en' => '8 Days',
                'duration_ar' => '٨ أيام',
                'groupSize_en' => '2-4 People',
                'groupSize_ar' => '٢-٤ أشخاص',
                'features_en' => json_encode(['Diving', 'Private Beach', 'Sunset Cruises', 'Wildlife Tours']),
                'features_ar' => json_encode(['الغوص', 'شاطئ خاص', 'رحلات الغروب', 'جولات الحياة البرية']),
                'image' => 'islands/seychelles.jpg',
                'price' => 3200.00,
                'rating' => 4.9,
                'slug' => 'seychelles-luxury',
                'active' => true,
            ],
        ];

        // Insert or update destinations based on type condition
        foreach ($destinations as $destination) {
            IslandDestination::updateOrCreate(
                // Match by slug to avoid duplicates
                ['slug' => $destination['slug']],
                // Update with all destination data
                $destination
            );
        }

        // Log seeding completion
        $localCount = IslandDestination::where('type', 'local')->count();
        $internationalCount = IslandDestination::where('type', 'international')->count();
        
        echo "✅ Island Destinations Seeded Successfully!\n";
        echo "   Local: {$localCount} | International: {$internationalCount}\n";
    }
}

