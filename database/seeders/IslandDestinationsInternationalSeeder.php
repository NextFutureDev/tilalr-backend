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
<<<<<<< Updated upstream
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
=======
            ['title_en' => 'Maldives Paradise Island', 'title_ar' => 'جزيرة المالديف الفردوس', 'type_en' => 'Tropical Resort', 'type_ar' => 'منتجع استوائي', 'description_en' => 'Experience luxury at its finest with crystal clear waters and pristine beaches.', 'description_ar' => 'اختبر الفخامة بأفضل صورها مع المياه الصافية والشواطئ النقية.', 'location_en' => 'Maldives', 'location_ar' => 'المالديف', 'duration_en' => '7 Days', 'duration_ar' => '٧ أيام', 'groupSize_en' => '2-4 People', 'groupSize_ar' => '٢-٤ أشخاص', 'price' => 2500, 'rating' => 4.8, 'image' => '/international/1.webp', 'slug' => 'maldives-paradise', 'active' => true],
            ['title_en' => 'Bali Island Escape', 'title_ar' => 'رحلة جزيرة بالي', 'type_en' => 'Cultural Island', 'type_ar' => 'جزيرة ثقافية', 'description_en' => 'Discover the cultural richness and natural beauty of Bali.', 'description_ar' => 'اكتشف الثروة الثقافية والجمال الطبيعي لبالي.', 'location_en' => 'Indonesia', 'location_ar' => 'إندونيسيا', 'duration_en' => '5 Days', 'duration_ar' => '٥ أيام', 'groupSize_en' => '2-6 People', 'groupSize_ar' => '٢-٦ أشخاص', 'price' => 1800, 'rating' => 4.7, 'image' => '/international/2.webp', 'slug' => 'bali-escape', 'active' => true],
            ['title_en' => 'Seychelles Luxury Retreat', 'title_ar' => 'ملجأ سيشل الفاخر', 'type_en' => 'Luxury Paradise', 'type_ar' => 'جنة فاخرة', 'description_en' => 'Exclusive tropical paradise with white sand beaches and turquoise lagoons.', 'description_ar' => 'جنة استوائية حصرية مع شواطئ رملية بيضاء وبحيرات فيروزية.', 'location_en' => 'Seychelles', 'location_ar' => 'سيشل', 'duration_en' => '8 Days', 'duration_ar' => '٨ أيام', 'groupSize_en' => '2-4 People', 'groupSize_ar' => '٢-٤ أشخاص', 'price' => 3200, 'rating' => 4.9, 'image' => '/international/3.webp', 'slug' => 'seychelles-luxury', 'active' => true],
            ['title_en' => 'Fiji Island Adventure', 'title_ar' => 'مغامرة جزر فيجي', 'type_en' => 'Island Paradise', 'type_ar' => 'جنة جزيرة', 'description_en' => 'Adventure and relaxation in tropical Fiji islands.', 'description_ar' => 'المغامرة والاسترخاء في جزر فيجي الاستوائية.', 'location_en' => 'Fiji', 'location_ar' => 'فيجي', 'duration_en' => '6 Days', 'duration_ar' => '٦ أيام', 'groupSize_en' => '2-5 People', 'groupSize_ar' => '٢-٥ أشخاص', 'price' => 2200, 'rating' => 4.6, 'image' => '/international/4.webp', 'slug' => 'fiji-adventure', 'active' => true],
            ['title_en' => 'Hawaii Tropical Paradise', 'title_ar' => 'جنة هاواي الاستوائية', 'type_en' => 'Beach Resort', 'type_ar' => 'منتجع شاطئي', 'description_en' => 'Stunning beaches and volcanic landscapes in Hawaii.', 'description_ar' => 'شواطئ خلابة ومناظر بركانية في هاواي.', 'location_en' => 'Hawaii', 'location_ar' => 'هاواي', 'duration_en' => '7 Days', 'duration_ar' => '٧ أيام', 'groupSize_en' => '2-6 People', 'groupSize_ar' => '٢-٦ أشخاص', 'price' => 3000, 'rating' => 4.8, 'image' => '/international/5.webp', 'slug' => 'hawaii-paradise', 'active' => true],
            ['title_en' => 'Thailand Beach Getaway', 'title_ar' => 'رحلة شاطئ تايلاند', 'type_en' => 'Exotic Beach', 'type_ar' => 'شاطئ غريب', 'description_en' => 'Experience Thai culture and beautiful beaches.', 'description_ar' => 'اختبر الثقافة التايلاندية والشواطئ الجميلة.', 'location_en' => 'Thailand', 'location_ar' => 'تايلاند', 'duration_en' => '5 Days', 'duration_ar' => '٥ أيام', 'groupSize_en' => '2-8 People', 'groupSize_ar' => '٢-٨ أشخاص', 'price' => 1600, 'rating' => 4.7, 'image' => '/international/6.webp', 'slug' => 'thailand-getaway', 'active' => true],
            ['title_en' => 'Mauritius Escape', 'title_ar' => 'رحلة موريشيوس', 'type_en' => 'Island Escape', 'type_ar' => 'هروب جزيرة', 'description_en' => 'Pristine beaches and cultural diversity in Mauritius.', 'description_ar' => 'شواطئ نقية وتنوع ثقافي في موريشيوس.', 'location_en' => 'Mauritius', 'location_ar' => 'موريشيوس', 'duration_en' => '6 Days', 'duration_ar' => '٦ أيام', 'groupSize_en' => '2-4 People', 'groupSize_ar' => '٢-٤ أشخاص', 'price' => 2400, 'rating' => 4.7, 'image' => '/international/7.webp', 'slug' => 'mauritius-escape', 'active' => true],
            ['title_en' => 'Bora Bora Island Tour', 'title_ar' => 'جولة جزيرة بورا بورا', 'type_en' => 'Luxury Getaway', 'type_ar' => 'رحلة فاخرة', 'description_en' => 'Overwater bungalows and crystal clear lagoons.', 'description_ar' => 'أكواخ فوق الماء وبحيرات صافية.', 'location_en' => 'French Polynesia', 'location_ar' => 'بولينيزيا الفرنسية', 'duration_en' => '7 Days', 'duration_ar' => '٧ أيام', 'groupSize_en' => '2-4 People', 'groupSize_ar' => '٢-٤ أشخاص', 'price' => 3500, 'rating' => 4.9, 'image' => '/international/8.webp', 'slug' => 'bora-bora-tour', 'active' => true],
            ['title_en' => 'Caribbean Cruise Dream', 'title_ar' => 'رحلة حلم البحر الكاريبي', 'type_en' => 'Cruise Vacation', 'type_ar' => 'عطلة رحلة بحرية', 'description_en' => 'Island hopping adventure in the Caribbean.', 'description_ar' => 'مغامرة القفز بين الجزر في البحر الكاريبي.', 'location_en' => 'Caribbean', 'location_ar' => 'البحر الكاريبي', 'duration_en' => '8 Days', 'duration_ar' => '٨ أيام', 'groupSize_en' => '4-10 People', 'groupSize_ar' => '٤-١٠ أشخاص', 'price' => 2800, 'rating' => 4.6, 'image' => '/international/9.webp', 'slug' => 'caribbean-cruise', 'active' => true],
            ['title_en' => 'Palau Island Discovery', 'title_ar' => 'اكتشاف جزيرة بالاو', 'type_en' => 'Diving Paradise', 'type_ar' => 'جنة الغوص', 'description_en' => 'World-class diving and pristine marine life.', 'description_ar' => 'الغوص من الدرجة الأولى والحياة البحرية النقية.', 'location_en' => 'Palau', 'location_ar' => 'بالاو', 'duration_en' => '6 Days', 'duration_ar' => '٦ أيام', 'groupSize_en' => '2-6 People', 'groupSize_ar' => '٢-٦ أشخاص', 'price' => 2600, 'rating' => 4.8, 'image' => '/international/10.webp', 'slug' => 'palau-discovery', 'active' => true],
            ['title_en' => 'Santorini Greece Escape', 'title_ar' => 'رحلة سانتوريني اليونان', 'type_en' => 'Romantic Getaway', 'type_ar' => 'رحلة رومانسية', 'description_en' => 'White-washed buildings and stunning Mediterranean views.', 'description_ar' => 'مباني بيضاء ومناظر متوسطة خلابة.', 'location_en' => 'Greece', 'location_ar' => 'اليونان', 'duration_en' => '5 Days', 'duration_ar' => '٥ أيام', 'groupSize_en' => '2-4 People', 'groupSize_ar' => '٢-٤ أشخاص', 'price' => 2000, 'rating' => 4.9, 'image' => '/international/11.webp', 'slug' => 'santorini-escape', 'active' => true],
            ['title_en' => 'Maldives Water Bungalow', 'title_ar' => 'أكواخ المالديف المائية', 'type_en' => 'Luxury Island', 'type_ar' => 'جزيرة فاخرة', 'description_en' => 'Exclusive water villas and underwater dining.', 'description_ar' => 'فيلات مائية حصرية وتناول طعام تحت الماء.', 'location_en' => 'Maldives', 'location_ar' => 'المالديف', 'duration_en' => '7 Days', 'duration_ar' => '٧ أيام', 'groupSize_en' => '2-3 People', 'groupSize_ar' => '٢-٣ أشخاص', 'price' => 4000, 'rating' => 5.0, 'image' => '/international/12.webp', 'slug' => 'maldives-bungalow', 'active' => true],
            ['title_en' => 'Maldives Resort Retreat', 'title_ar' => 'ملجأ منتجع المالديف', 'type_en' => 'All-Inclusive Resort', 'type_ar' => 'منتجع شامل', 'description_en' => 'All-inclusive tropical island resort experience.', 'description_ar' => 'تجربة منتجع جزيرة استوائية شاملة.', 'location_en' => 'Maldives', 'location_ar' => 'المالديف', 'duration_en' => '6 Days', 'duration_ar' => '٦ أيام', 'groupSize_en' => '2-8 People', 'groupSize_ar' => '٢-٨ أشخاص', 'price' => 2700, 'rating' => 4.8, 'image' => '/international/13.webp', 'slug' => 'maldives-resort', 'active' => true],
            ['title_en' => 'Bali Beach Bliss', 'title_ar' => 'نعيم شاطئ بالي', 'type_en' => 'Beach Vacation', 'type_ar' => 'عطلة شاطئ', 'description_en' => 'Tropical beaches and ancient temple exploration.', 'description_ar' => 'شواطئ استوائية واستكشاف المعابد القديمة.', 'location_en' => 'Indonesia', 'location_ar' => 'إندونيسيا', 'duration_en' => '5 Days', 'duration_ar' => '٥ أيام', 'groupSize_en' => '2-6 People', 'groupSize_ar' => '٢-٦ أشخاص', 'price' => 1500, 'rating' => 4.6, 'image' => '/international/14.webp', 'slug' => 'bali-bliss', 'active' => true],
            ['title_en' => 'Aruba Island Adventure', 'title_ar' => 'مغامرة جزيرة أروبا', 'type_en' => 'Adventure Island', 'type_ar' => 'جزيرة مغامرة', 'description_en' => 'Sunny beaches and water sports paradise.', 'description_ar' => 'شواطئ مشمسة وجنة الألعاب المائية.', 'location_en' => 'Aruba', 'location_ar' => 'أروبا', 'duration_en' => '5 Days', 'duration_ar' => '٥ أيام', 'groupSize_en' => '2-6 People', 'groupSize_ar' => '٢-٦ أشخاص', 'price' => 1900, 'rating' => 4.7, 'image' => '/international/15.webp', 'slug' => 'aruba-adventure', 'active' => true],
            ['title_en' => 'Zanzibar Spice Island', 'title_ar' => 'جزيرة زنجبار الفاخرة', 'type_en' => 'Cultural Paradise', 'type_ar' => 'جنة ثقافية', 'description_en' => 'Historic spice island with swahili culture.', 'description_ar' => 'جزيرة تاريخية بثقافة سواحيلية.', 'location_en' => 'Tanzania', 'location_ar' => 'تنزانيا', 'duration_en' => '6 Days', 'duration_ar' => '٦ أيام', 'groupSize_en' => '2-5 People', 'groupSize_ar' => '٢-٥ أشخاص', 'price' => 2100, 'rating' => 4.5, 'image' => '/international/16.webp', 'slug' => 'zanzibar-spice', 'active' => true],
>>>>>>> Stashed changes
        ];

        foreach ($destinations as $destination) {
            IslandDestination::updateOrCreate(
                ['slug' => $destination['slug']],
                $destination
            );
        }
    }
}
