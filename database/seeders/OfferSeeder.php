<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    public function run()
    {
        $offers = [
            [
                'slug' => 'trip-to-alula',
                'image' => '/offers/corporate-trips.jpg',
                'title_en' => 'Trip to AlUla',
                'title_ar' => 'رحلة إلى العلا',
                'description_en' => 'Join us on a trip to AlUla, where you can discover breathtaking natural landscapes and historical landmarks like Hegra (Mada\'in Saleh).',
                'description_ar' => 'انضم إلينا في رحلة إلى العلا، حيث يمكنك اكتشاف المناظر الطبيعية الخلابة والمعالم التاريخية.',
                'duration' => '3 Days 2 Nights',
                'location_en' => 'AlUla, Saudi Arabia',
                'location_ar' => 'العلا، السعودية',
                'group_size' => '2-15 Persons',
                'discount' => '25%',
                'badge' => 'Most Popular',
                'features' => ['Hotel accommodation','All transportation','Professional guide','Desert safari','Camping experience','All meals included'],
                'highlights' => ['Hegra Visit','Desert Camping','Star Gazing','Historical Sites'],
                'is_active' => true,
            ],
            [
                'slug' => 'jeddah-sea-cruise',
                'image' => '/offers/jeddah-sea.png',
                'title_en' => 'Charming Sea Cruise in Jeddah',
                'title_ar' => 'رحلة بحرية ساحرة في جدة',
                'description_en' => 'Relax on a sea cruise to Jeddah and enjoy beautiful marine views and beach activities.',
                'description_ar' => 'استمتع برحلة بحرية إلى جدة واستمتع بأجمل المناظر البحرية وأنشطة الشاطئ.',
                'duration' => '2 Days 1 Night',
                'location_en' => 'Jeddah, Red Sea',
                'location_ar' => 'جدة، البحر الأحمر',
                'group_size' => '4-20 Persons',
                'discount' => '25%',
                'badge' => 'Limited Spots',
                'features' => ['Luxury cruise ship','All meals & snacks','Snorkeling equipment','Professional crew','Beach activities','Photography service'],
                'highlights' => ['Red Sea Views','Snorkeling','Beach Relaxation','Marine Life'],
                'is_active' => true,
            ],
        ];

        foreach ($offers as $o) {
            Offer::updateOrCreate(['slug' => $o['slug']], $o);
        }
    }
}
