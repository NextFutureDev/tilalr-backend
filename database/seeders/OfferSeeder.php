<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    public function run()
    {
        // Clear existing offers
        DB::table('offers')->truncate();
        
        $offers = [
            [
                'slug' => 'alula-day-trip',
                'image' => '/354.jpeg',
                'title_en' => 'AlUla Day Trip',
                'title_ar' => 'رحلة العلا يوم واحد',
                'description_en' => 'A full-day AlUla tour visiting natural and heritage highlights with lunch in nature.',
                'description_ar' => 'جولة ليوم كامل في العلا لزيارة المعالم الطبيعية والتراثية مع غداء في الطبيعة.',
                'duration_en' => '1 Day',
                'duration_ar' => 'يوم واحد',
                'location_en' => 'AlUla, Saudi Arabia',
                'location_ar' => 'العلا، السعودية',
                'group_size_en' => '2-15 Persons',
                'group_size_ar' => '2-15 أشخاص',
                'badge_en' => 'Most Popular',
                'badge_ar' => 'الأكثر شيوعاً',
                'features_en' => json_encode(['Round-trip transportation from Al-Madinah', 'Lunch in nature', 'Guided visits']),
                'features_ar' => json_encode(['المواصلات ذهابًا وعودة من المدينة المنورة', 'وجبة غداء في الطبيعة', 'زيارات بصحبة مرشد']),
                'highlights_en' => json_encode(['Al-Maraya Theater (visit subject to availability)', 'Elephant Rock', 'Old Town']),
                'highlights_ar' => json_encode(['مسرح مرايا (حسب التوافر)', 'جبل الفيل', 'البلدة القديمة']),
                'is_active' => true,
            ],
            [
                'slug' => 'alula-two-days',
                'image' => '/1800.jpeg',
                'title_en' => 'Two-Day AlUla Overnight',
                'title_ar' => 'رحلة مبيت يومين للعلا',
                'description_en' => 'A two-day AlUla overnight experience covering key heritage sites, farm stay, and Hegra visit.',
                'description_ar' => 'تجربة مبيت لمدة يومين في العلا تشمل المواقع التراثية الرئيسية والإقامة في مزرعة وزيارة الحجر.',
                'duration_en' => '2 Days 1 Night',
                'duration_ar' => 'يومان ليلة واحدة',
                'location_en' => 'AlUla, Saudi Arabia',
                'location_ar' => 'العلا، السعودية',
                'group_size_en' => '4-20 Persons',
                'group_size_ar' => '4-20 أشخاص',
                'badge_en' => 'Limited Spots',
                'badge_ar' => 'أماكن محدودة',
                'features_en' => json_encode(['Farm stay', 'Guided Hegra visit', 'Meals included']),
                'features_ar' => json_encode(['إقامة في مزرعة', 'زيارة الحجر بصحبة مرشد', 'الوجبات مشمولة']),
                'highlights_en' => json_encode(['Shabtraz Farm', 'Hegra (Mada\'in Saleh)', 'Al-Maraya Theater']),
                'highlights_ar' => json_encode(['مزرعة شابترز', 'الحجر (مدائن صالح)', 'مسرح مرايا']),
                'is_active' => true,
            ],
            [
                'slug' => 'alula-three-days',
                'image' => '/3200.jpeg',
                'title_en' => 'Three Days AlUla Experience',
                'title_ar' => 'رحلة مبيت ٣ أيام العلا',
                'description_en' => 'A three-day AlUla program featuring camps, guided archaeological tours, and cultural experiences.',
                'description_ar' => 'برنامج لمدة ثلاثة أيام في العلا يتضمن المخيمات والجولات الأثرية المرشدة والتجارب الثقافية.',
                'duration_en' => '3 Days 2 Nights',
                'duration_ar' => '3 أيام ليلتان',
                'location_en' => 'AlUla, Saudi Arabia',
                'location_ar' => 'العلا، السعودية',
                'group_size_en' => '4-20 Persons',
                'group_size_ar' => '4-20 أشخاص',
                'badge_en' => 'New Experience',
                'badge_ar' => 'تجربة جديدة',
                'features_en' => json_encode(['Camps & farms', 'Guided tours', 'All meals']),
                'features_ar' => json_encode(['مخيمات ومزارع', 'جولات مرشدة', 'جميع الوجبات']),
                'highlights_en' => json_encode(['Hegra', 'Al-Maraya Theater', 'Elephant Rock']),
                'highlights_ar' => json_encode(['الحجر', 'مسرح مرايا', 'جبل الفيل']),
                'is_active' => true,
            ],
        ];

        foreach ($offers as $o) {
            Offer::create($o);
        }
    }
}
