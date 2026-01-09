<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Seeder;

class WinterEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure Jeddah city reference when available; create minimal record if missing
        $jeddah = \App\Models\City::firstOrCreate(
            ['slug' => 'jeddah'],
            ['name' => 'Jeddah']
        );

        $events = [
            [
                'en' => [
                    'title' => 'Winter Tilal & Sand — Egyptian Night',
                    'slug' => 'winter-tilal-egyptian-night',
                    'description' => 'Experience the pleasure — live oud performance, BBQ dinner, warm sessions and an archery challenge under the stars.',
                    'content' => 'Live oud performance, warm sessions, delightful drinks, a BBQ feast and an archery challenge. Evening runs from 16:00 to 24:00.',
                    'image' => '/trips/egyptian.jpg',
                    'video' => '/videos/egyptian.mp4',
                    'type' => 'event',
                    'highlights' => ['Live Oud Performance','Warm Sessions','Drinks & BBQ','Archery Challenge'],
                    'group_size' => '20-50 Persons',
                    'lang' => 'en',
                    'city_name' => 'Jeddah - Alghola',
                    'start_date' => '2024-01-24',
                ],
                'ar' => [
                    'title' => 'شتوية التلال والرمال',
                    'slug' => 'winter-tilal-egyptian-night-ar',
                    'description' => 'عيش المتعة',
                    'content' => "جلسة طربية، جلسات دافئة، متعة المشروبات، الاستمتاع بوجبة الشواء، تحدي الرماية\nالجمعة ٢٤ يناير — جدة-الغولا — ٤ - ١٢ مساء",
                    'image' => '/trips/egyptian.jpg',
                    'video' => '/videos/egyptian.mp4',
                    'type' => 'event',
                    'highlights' => ['جلسة طربية','جلسات دافئة','متعة المشروبات','الاستمتاع بوجبة الشواء','تحدي الرماية'],
                    'group_size' => '٢٠-٥٠ شخص',
                    'lang' => 'ar',
                    'city_name' => 'جدة - الغولا',
                    'start_date' => '2024-01-24',
                ],
            ],

            [
                'en' => [
                    'title' => 'Founding Day at Winter Tilal & Sand',
                    'slug' => 'winter-tilal-founding-day',
                    'description' => 'Founding Day celebration — parades, live oud, folkloric bands, traditional hospitality, horse & camel riding.',
                    'content' => "Parade and celebratory performances. Live oud session by 'Al-Omda', folkloric bands, traditional hospitality, and horse & camel riding. Time: 17:00-00:00.",
                    'image' => '/trips/saudifounday.jpg',
                    'video' => '/videos/saudifounday.mp4',
                    'type' => 'event',
                    'highlights' => ['Parade','Oud Session','Folklore Bands','Camel & Horse Riding','Traditional Hospitality'],
                    'group_size' => '30-100 Persons',
                    'lang' => 'en',
                    'city_name' => 'Jeddah - Alghola',
                    'start_date' => '2024-02-03',
                ],
                'ar' => [
                    'title' => 'يوم التأسيس في شتوية التلال والرمال',
                    'slug' => 'yawm-al-tasis-shatwiyat-tilal',
                    'description' => 'يوم بدينا',
                    'content' => "اعيش اجواء مختلفة\nمسيرة يوم التأسيس، جلسة مع انغام العود بصوت الفنان \"العمدة\"، فرقة شعبية وفلكلور، فرقة شعبية نسائية، الضيافة الشعبية، ركوب الخيول والجمال\nالسبت ٢٣ فبراير — جدة-الغولا — ٤ - ١١ مساء",
                    'image' => '/trips/saudifounday.jpg',
                    'video' => '/videos/saudifounday.mp4',
                    'type' => 'event',
                    'highlights' => ['مسيرة يوم التأسيس','جلسة عود','فرق شعبية وفلكلور','ركوب الخيل والجمال','الضيافة الشعبية'],
                    'group_size' => '٣٠-١٠٠ شخص',
                    'lang' => 'ar',
                    'city_name' => 'جدة - الغولا',
                    'start_date' => '2024-02-03',
                ],
            ],

            [
                'en' => [
                    'title' => 'Egyptian Cultural Night at Winter Tilal & Sand',
                    'slug' => 'winter-tilal-egyptian-cultural-night',
                    'description' => 'Live a different atmosphere. Enjoy evening activities in nature with oud performances and Egyptian cuisine.',
                    'content' => 'Experience different vibes. Oud session by "Al-Omda", dinner buffet with Egyptian dishes, and classic melodies session by "Amthal". Monday, February 3 — Jeddah - Alghola — 5:00 PM to 12:00 AM.',
                    'image' => '/trips/jeddah.jpg',
                    'video' => '/videos/jeddah.mp4',
                    'type' => 'event',
                    'highlights' => ['Oud Performance by Al-Omda','Egyptian Cuisine','Classic Melodies by Amthal','Natural Atmosphere'],
                    'group_size' => '20-60 Persons',
                    'lang' => 'en',
                    'city_name' => 'Jeddah - Alghola',
                    'start_date' => '2024-02-03',
                ],
                'ar' => [
                    'title' => 'ليلة مصرية في شتوية التلال والرمال',
                    'slug' => 'laylat-misriyya-shatwiyat-tilal',
                    'description' => 'عيش اجواء مختلفة',
                    'content' => "الاستمتاع بفقرات الأمسية في اجواء الطبيعة\nجلسة طربية على انغام العود بصوت \"العمدة\"، وجبة عشاء مشاوي واكلات مصرية، جلسة مع الانغام القديمة بصوت \"امثال\"\nالاثنين ٣ فبراير — جدة-الغولا — ٥ - ١٢ مساء",
                    'image' => '/trips/jeddah.jpg',
                    'video' => '/videos/jeddah.mp4',
                    'type' => 'event',
                    'highlights' => ['جلسة طربية','أكلات مصرية','جلسة انغام كلاسيكية','أجواء طبيعية'],
                    'group_size' => '٢٠-٦٠ شخص',
                    'lang' => 'ar',
                    'city_name' => 'جدة - الغولا',
                    'start_date' => '2024-02-03',
                ],
            ],
        ];

        foreach ($events as $pair) {
            // English row
            Trip::updateOrCreate([
                'slug' => $pair['en']['slug'],
                'lang' => 'en',
            ], array_merge($pair['en'], [
                'city_id' => $jeddah ? $jeddah->id : null,
            ]));

            // Arabic row
            Trip::updateOrCreate([
                'slug' => $pair['ar']['slug'],
                'lang' => 'ar',
            ], array_merge($pair['ar'], [
                'city_id' => $jeddah ? $jeddah->id : null,
            ]));
        }
    }
}
