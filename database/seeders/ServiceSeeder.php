<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        DB::table('services')->insert([
            [
                'slug' => 'school-trips',
                'icon' => 'services/school-trip.webp',
                'name' => json_encode([
                    'en' => 'School Trips',
                    'ar' => 'رحلات المدارس',
                ]),
                'short_description' => json_encode([
                    'en' => 'Fun educational trips combining learning and entertainment, including workshops and cultural site visits.',
                    'ar' => 'رحلات تعليمية ممتعة تجمع بين التعلم والترفيه، تشمل ورش عمل وزيارات لمواقع ثقافية.',
                ]),
                'description' => json_encode([
                    'en' => 'We offer fun educational trips that combine learning and entertainment. Includes workshops and visits to cultural sites, providing a unique educational experience for students.',
                    'ar' => 'نقدم رحلات تعليمية ممتعة تجمع بين التعلم والترفيه. تشمل ورش عمل وزيارات لمواقع ثقافية مما يوفر تجربة تعليمية فريدة للطلاب.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'corporate-trips',
                'icon' => 'services/corporate-trips.jpeg',
                'name' => json_encode([
                    'en' => 'Corporate Trips',
                    'ar' => 'رحلات الشركات',
                ]),
                'short_description' => json_encode([
                    'en' => 'Motivational trips to strengthen cooperation and creativity among employees.',
                    'ar' => 'رحلات تحفيزية لتعزيز التعاون والإبداع بين الموظفين.',
                ]),
                'description' => json_encode([
                    'en' => 'Make your company events special! We offer motivational trips to enhance cooperation and creativity among employees, with interactive activities and team building to strengthen group spirit.',
                    'ar' => 'اجعل فعاليات شركتك مميزة! نقدم رحلات تحفيزية لتعزيز التعاون والإبداع بين الموظفين مع أنشطة تفاعلية وبناء فرق لتعزيز الروح الجماعية.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'family-private-group-trips',
                'icon' => 'services/family-trips.jpeg',
                'name' => json_encode([
                    'en' => 'Family & Private Group Trips',
                    'ar' => 'رحلات العوائل والمجموعات الخاصة',
                ]),
                'short_description' => json_encode([
                    'en' => 'Custom trips for families and private groups with unforgettable experiences.',
                    'ar' => 'رحلات مخصصة للعوائل والمجموعات الخاصة بتجارب لا تنسى.',
                ]),
                'description' => json_encode([
                    'en' => 'Enjoy wonderful time with your family or friends! We offer customized trips suitable for all tastes, with unique experiences that guarantee unforgettable memories.',
                    'ar' => 'استمتع بوقت ممتع مع عائلتك أو أصدقائك! نقدم رحلات مخصصة تناسب جميع الأذواق مع تجارب فريدة تضمن لكم ذكريات لا تنسى.',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
