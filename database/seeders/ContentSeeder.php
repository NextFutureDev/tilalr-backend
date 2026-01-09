<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\City;
use App\Models\Trip;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Create Services
        Service::create([
            'title' => 'خدمات السياحة',
            'slug' => 'tourism-services',
            'description' => 'نقدم أفضل خدمات السياحة في المملكة العربية السعودية',
            'content' => 'خدمات سياحية متكاملة تشمل الحجوزات والجولات السياحية',
            'icon' => 'plane',
            'order' => 1,
            'lang' => 'ar',
            'is_active' => true,
        ]);

        Service::create([
            'title' => 'Tourism Services',
            'slug' => 'tourism-services-en',
            'description' => 'We provide the best tourism services in Saudi Arabia',
            'content' => 'Comprehensive tourism services including bookings and tours',
            'icon' => 'plane',
            'order' => 1,
            'lang' => 'en',
            'is_active' => true,
        ]);

        // Create Cities
        $riyadh = City::create([
            'name' => 'الرياض',
            'slug' => 'riyadh',
            'description' => 'عاصمة المملكة العربية السعودية',
            'country' => 'Saudi Arabia',
            'order' => 1,
            'lang' => 'ar',
            'is_active' => true,
        ]);

        $jeddah = City::create([
            'name' => 'جدة',
            'slug' => 'jeddah',
            'description' => 'عروس البحر الأحمر',
            'country' => 'Saudi Arabia',
            'order' => 2,
            'lang' => 'ar',
            'is_active' => true,
        ]);

        // Create Trips
        Trip::create([
            'title' => 'جولة الرياض التاريخية',
            'slug' => 'riyadh-historical-tour',
            'description' => 'استكشف معالم الرياض التاريخية والحديثة',
            'content' => 'جولة شاملة تشمل حي الطريف، المتحف الوطني، وبرج المملكة',
            'price' => 500.00,
            'duration' => 3,
            'type' => 'saudi',
            'city_id' => $riyadh->id,
            'order' => 1,
            'lang' => 'ar',
            'is_active' => true,
        ]);

        Trip::create([
            'title' => 'رحلة جدة الساحلية',
            'slug' => 'jeddah-coastal-trip',
            'description' => 'استمتع بشواطئ جدة الخلابة',
            'content' => 'رحلة بحرية مع زيارة الكورنيش والبلد التاريخي',
            'price' => 750.00,
            'duration' => 2,
            'type' => 'saudi',
            'city_id' => $jeddah->id,
            'order' => 2,
            'lang' => 'ar',
            'is_active' => true,
        ]);

        // Create Products
        Product::create([
            'name' => 'باقة العمرة',
            'slug' => 'umrah-package',
            'description' => 'باقة عمرة متكاملة مع خدمات VIP',
            'price' => 3500.00,
            'category' => 'religious',
            'order' => 1,
            'lang' => 'ar',
            'is_active' => true,
        ]);

        // Create Testimonials
        Testimonial::create([
            'name' => 'أحمد محمد',
            'position' => 'مسافر',
            'content' => 'تجربة رائعة مع تلال الرمال، الخدمة ممتازة والتنظيم احترافي',
            'rating' => 5,
            'order' => 1,
            'lang' => 'ar',
            'is_active' => true,
        ]);

        Testimonial::create([
            'name' => 'فاطمة علي',
            'position' => 'عميلة',
            'content' => 'أفضل وكالة سفر تعاملت معها، أنصح الجميع بالتعامل معهم',
            'rating' => 5,
            'order' => 2,
            'lang' => 'ar',
            'is_active' => true,
        ]);

        // Create Team Members
        TeamMember::create([
            'name' => 'محمد السعيد',
            'position' => 'مدير السياحة',
            'bio' => 'خبرة 15 عام في مجال السياحة',
            'email' => 'mohammed@tilrimal.com',
            'order' => 1,
            'lang' => 'ar',
            'is_active' => true,
        ]);

        // Create Settings
        Setting::create(['key' => 'site_name_ar', 'value' => 'تلال الرمال', 'type' => 'text', 'group' => 'general']);
        Setting::create(['key' => 'site_name_en', 'value' => 'Tilal Rimal', 'type' => 'text', 'group' => 'general']);
        Setting::create(['key' => 'site_email', 'value' => 'info@tilrimal.com', 'type' => 'email', 'group' => 'contact']);
        Setting::create(['key' => 'site_phone', 'value' => '+966 XX XXX XXXX', 'type' => 'text', 'group' => 'contact']);
        Setting::create(['key' => 'whatsapp_number', 'value' => '+966XXXXXXXXX', 'type' => 'text', 'group' => 'contact']);
    }
}
