<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InternationalFlight;
use App\Models\InternationalHotel;
use App\Models\InternationalPackage;
use App\Models\InternationalDestination;

class InternationalDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Flights Data
        InternationalFlight::create([
            'airline_en' => 'Emirates',
            'airline_ar' => 'الإمارات',
            'route_en' => 'Jeddah → Dubai',
            'route_ar' => 'جدة → دبي',
            'departure_time' => '06:00 AM',
            'arrival_time' => '08:30 AM',
            'duration' => '2h 30m',
            'stops_en' => 'Non-stop',
            'stops_ar' => 'بدون توقف',
            'price' => 299.00,
            'active' => true,
        ]);

        InternationalFlight::create([
            'airline_en' => 'Turkish Airlines',
            'airline_ar' => 'الخطوط التركية',
            'route_en' => 'Riyadh → Istanbul',
            'route_ar' => 'الرياض → إسطنبول',
            'departure_time' => '10:00 AM',
            'arrival_time' => '02:15 PM',
            'duration' => '4h 15m',
            'stops_en' => 'Non-stop',
            'stops_ar' => 'بدون توقف',
            'price' => 349.00,
            'active' => true,
        ]);

        InternationalFlight::create([
            'airline_en' => 'British Airways',
            'airline_ar' => 'بريتيش إيرويز',
            'route_en' => 'Dammam → London',
            'route_ar' => 'الدمام → لندن',
            'departure_time' => '08:00 PM',
            'arrival_time' => '02:45 AM',
            'duration' => '6h 45m',
            'stops_en' => 'Non-stop',
            'stops_ar' => 'بدون توقف',
            'price' => 599.00,
            'active' => true,
        ]);

        InternationalFlight::create([
            'airline_en' => 'Qatar Airways',
            'airline_ar' => 'الخطوط القطرية',
            'route_en' => 'Medina → Bangkok',
            'route_ar' => 'المدينة → بانكوك',
            'departure_time' => '02:00 PM',
            'arrival_time' => '09:30 PM',
            'duration' => '7h 30m',
            'stops_en' => '1 stop (Doha)',
            'stops_ar' => 'توقف واحد (الدوحة)',
            'price' => 449.00,
            'active' => true,
        ]);

        // Hotels Data
        InternationalHotel::create([
            'name_en' => 'Burj Al Arab',
            'name_ar' => 'برج العرب',
            'location_en' => 'Dubai, UAE',
            'location_ar' => 'دبي، الإمارات',
            'description_en' => 'Iconic luxury hotel with world-class amenities',
            'description_ar' => 'فندق فاخر أيقوني مع مرافق عالمية المستوى',
            'rating' => 5,
            'price' => 450.00,
            'image' => '/international/dubai.webp',
            'amenities_en' => json_encode(['Beach Front', 'Spa', 'Pool', 'Free WiFi']),
            'amenities_ar' => json_encode(['شاطئ خاص', 'سبا', 'مسبح', 'واي فاي مجاني']),
            'active' => true,
        ]);

        InternationalHotel::create([
            'name_en' => 'The Ritz Paris',
            'name_ar' => 'ريتز باريس',
            'location_en' => 'Paris, France',
            'location_ar' => 'باريس، فرنسا',
            'description_en' => 'Legendary Parisian luxury hotel',
            'description_ar' => 'فندق فاخر باريسي أسطوري',
            'rating' => 5,
            'price' => 600.00,
            'image' => '/international/paris.jpg',
            'amenities_en' => json_encode(['City View', 'Fine Dining', 'Spa', 'Concierge']),
            'amenities_ar' => json_encode(['إطلالة على المدينة', 'مطعم فاخر', 'سبا', 'خدمة الكونسيرج']),
            'active' => true,
        ]);

        InternationalHotel::create([
            'name_en' => 'Mandarin Oriental',
            'name_ar' => 'ماندارين أورينتال',
            'location_en' => 'Bangkok, Thailand',
            'location_ar' => 'بانكوك، تايلاند',
            'description_en' => 'Riverside luxury resort with oriental charm',
            'description_ar' => 'منتجع فاخر على النهر برسحة شرقية',
            'rating' => 5,
            'price' => 350.00,
            'image' => '/international/Bangkok.webp',
            'amenities_en' => json_encode(['River View', 'Infinity Pool', 'Spa', 'Gym']),
            'amenities_ar' => json_encode(['إطلالة على النهر', 'مسبح لا متناهي', 'سبا', 'نادي رياضي']),
            'active' => true,
        ]);

        InternationalHotel::create([
            'name_en' => 'The Savoy',
            'name_ar' => 'السافوي',
            'location_en' => 'London, UK',
            'location_ar' => 'لندن، المملكة المتحدة',
            'description_en' => 'Historic luxury hotel in central London',
            'description_ar' => 'فندق فاخر تاريخي في وسط لندن',
            'rating' => 5,
            'price' => 550.00,
            'image' => '/international/uk.jpg',
            'amenities_en' => json_encode(['Historic', 'Afternoon Tea', 'Spa', 'Butler Service']),
            'amenities_ar' => json_encode(['تاريخي', 'شاي الظهيرة', 'سبا', 'خدمة الجرسون']),
            'active' => true,
        ]);

        // Packages Data
        InternationalPackage::create([
            'type_en' => 'Early Bird',
            'type_ar' => 'الحجز المبكر',
            'title_en' => 'Book 60 Days in Advance',
            'title_ar' => 'احجز قبل 60 يوم',
            'description_en' => 'Save up to 30% on international flights',
            'description_ar' => 'وفر حتى 30% على الرحلات الدولية',
            'image' => '/international/dubai.webp',
            'duration_en' => '5 Days 4 Nights',
            'duration_ar' => '٥ أيام ٤ ليالي',
            'price' => 1299.00,
            'discount' => '30% OFF',
            'features_en' => json_encode(['Flight Included', 'Hotel Stay', 'Airport Transfer']),
            'features_ar' => json_encode(['الرحلة مشمولة', 'إقامة الفندق', 'مواصلات المطار']),
            'highlight_en' => 'Best Seller',
            'highlight_ar' => 'الأكثر مبيعاً',
            'active' => true,
        ]);

        InternationalPackage::create([
            'type_en' => 'Family',
            'type_ar' => 'عائلة',
            'title_en' => 'Family Vacation Package',
            'title_ar' => 'حزمة العطلة العائلية',
            'description_en' => 'Kids under 12 stay and fly for free',
            'description_ar' => 'الأطفال تحت 12 سنة يطيرون ويقيمون مجاناً',
            'image' => '/international/paris.jpg',
            'duration_en' => '6 Days 5 Nights',
            'duration_ar' => '٦ أيام ٥ ليالي',
            'price' => 1899.00,
            'discount' => '15% OFF',
            'features_en' => json_encode(['Family Suite', 'Kids Activities', 'All Meals']),
            'features_ar' => json_encode(['جناح العائلة', 'أنشطة الأطفال', 'جميع الوجبات']),
            'highlight_en' => 'Limited Time',
            'highlight_ar' => 'وقت محدود',
            'active' => true,
        ]);

        InternationalPackage::create([
            'type_en' => 'Honeymoon',
            'type_ar' => 'شهر العسل',
            'title_en' => 'Romantic Getaway',
            'title_ar' => 'رحلة رومانسية',
            'description_en' => 'Complimentary upgrade and champagne',
            'description_ar' => 'ترقية مجانية وشامبانيا',
            'image' => '/international/Bangkok.webp',
            'duration_en' => '7 Days 6 Nights',
            'duration_ar' => '٧ أيام ٦ ليالي',
            'price' => 1499.00,
            'discount' => '20% OFF',
            'features_en' => json_encode(['Couple Suite', 'Spa Access', 'Romantic Dinner']),
            'features_ar' => json_encode(['جناح الزوجين', 'إمكانية الوصول إلى السبا', 'عشاء رومانسي']),
            'highlight_en' => 'Special',
            'highlight_ar' => 'خاص',
            'active' => true,
        ]);

        InternationalPackage::create([
            'type_en' => 'Last Minute',
            'type_ar' => 'آخر لحظة',
            'title_en' => 'Last Minute Deals',
            'title_ar' => 'عروض آخر لحظة',
            'description_en' => 'Up to 40% off on hotel bookings',
            'description_ar' => 'خصم حتى 40% على حجوزات الفنادق',
            'image' => '/international/Maldives.jpg',
            'duration_en' => '4 Days 3 Nights',
            'duration_ar' => '٤ أيام ٣ ليالي',
            'price' => 799.00,
            'discount' => '40% OFF',
            'features_en' => json_encode(['Quick Booking', 'Best Price', 'Free Cancellation']),
            'features_ar' => json_encode(['الحجز السريع', 'أفضل سعر', 'إلغاء مجاني']),
            'highlight_en' => 'Hot Deal',
            'highlight_ar' => 'صفقة ساخنة',
            'active' => true,
        ]);

        // Destinations Data
        InternationalDestination::create([
            'name_en' => 'Dubai, UAE',
            'name_ar' => 'دبي، الإمارات',
            'description_en' => 'Experience luxury and modernity',
            'description_ar' => 'اختبر الفخامة والحداثة',
            'image' => '/international/dubai.webp',
            'price' => 499.00,
            'active' => true,
        ]);

        InternationalDestination::create([
            'name_en' => 'Paris, France',
            'name_ar' => 'باريس، فرنسا',
            'description_en' => 'The city of love and lights',
            'description_ar' => 'مدينة الحب والأضواء',
            'image' => '/international/paris.jpg',
            'price' => 699.00,
            'active' => true,
        ]);

        InternationalDestination::create([
            'name_en' => 'Bangkok, Thailand',
            'name_ar' => 'بانكوك، تايلاند',
            'description_en' => 'Cultural paradise with amazing cuisine',
            'description_ar' => 'جنة ثقافية بمأكولات رائعة',
            'image' => '/international/Bangkok.webp',
            'price' => 399.00,
            'active' => true,
        ]);

        InternationalDestination::create([
            'name_en' => 'London, UK',
            'name_ar' => 'لندن، المملكة المتحدة',
            'description_en' => 'Historic capital with royal charm',
            'description_ar' => 'العاصمة التاريخية بالسحر الملكي',
            'image' => '/international/uk.jpg',
            'price' => 799.00,
            'active' => true,
        ]);

        InternationalDestination::create([
            'name_en' => 'Istanbul, Turkey',
            'name_ar' => 'إسطنبول، تركيا',
            'description_en' => 'Where east meets west',
            'description_ar' => 'حيث يلتقي الشرق والغرب',
            'image' => '/international/Turkey.webp',
            'price' => 449.00,
            'active' => true,
        ]);

        InternationalDestination::create([
            'name_en' => 'Maldives',
            'name_ar' => 'جزر المالديف',
            'description_en' => 'Tropical paradise getaway',
            'description_ar' => 'ملاذ الجنة الاستوائية',
            'image' => '/international/Maldives.jpg',
            'price' => 899.00,
            'active' => true,
        ]);
    }
}
