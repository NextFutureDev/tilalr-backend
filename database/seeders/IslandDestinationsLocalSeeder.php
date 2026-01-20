<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IslandDestination;
use App\Models\City;

class IslandDestinationsLocalSeeder extends Seeder
{
    public function run()
    {
        // Clear old local destinations first
        IslandDestination::where('type', 'local')->delete();

        // Create AlUla city
        $alula = City::firstOrCreate(
            ['slug' => 'alula'],
            ['name' => 'AlUla', 'lang' => 'en', 'is_active' => true]
        );

        // ============================================
        // Trip to AlUla - 1 Day (ID: 1)
        // ============================================
        IslandDestination::create([
            'slug' => 'trip-to-alula',
            'title_en' => 'Trip to AlUla',
            'title_ar' => 'رحلة العلا يوم واحد',
            'type' => 'local',
            'type_en' => 'Heritage Tour',
            'description_en' => 'Join us on a trip to AlUla, where you can discover breathtaking natural landscapes and historical landmarks like Hegra (Mada\'in Saleh). Immerse yourself in the beauty and history of AlUla with a comprehensive journey. Experience camping under the stars, explore AlHijra (UNESCO site), visit Al-Maraya Theater, and discover the stunning natural formations and heritage sites.',
            'description_ar' => 'انضم إلينا في رحلة إلى العلا، حيث يمكنك اكتشاف المناظر الطبيعية الخلابة والمعالم التاريخية مثل الحجر (مدائن صالح). انغمس في جمال وتاريخ العلا برحلة شاملة. خيم تحت النجوم، استكشف الحجر (موقع اليونسكو)، زر مسرح مرايا، واكتشف التكوينات الطبيعية المذهلة والمواقع التراثية.',
            'duration_en' => '1 Day',
            'duration_ar' => 'يوم واحد',
            'groupSize_en' => '2-15 Persons',
            'groupSize_ar' => '2-15 أشخاص',
            'location_en' => 'AlUla, Saudi Arabia',
            'location_ar' => 'العلا، السعودية',
            'price' => 354.00,
            'rating' => 4.9,
            'image' => null,
            'city_id' => $alula->id,
            'active' => true,
            'highlights_en' => json_encode(['Hegra Visit', 'Desert Camping', 'Star Gazing', 'Historical Sites']),
            'highlights_ar' => json_encode(['زيارة الحجر', 'التخييم الصحراوي', 'مراقبة النجوم', 'المواقع التاريخية']),
            'features' => json_encode([
                'All transportation',
                'Professional guide',
                'Desert safari',
                'Camping experience',
                'All meals included',
            ]),
            'features_ar' => json_encode([
                'جميع المواصلات',
                'مرشد محترف',
                'سفاري صحراوي',
                'تجربة التخييم',
                'جميع الوجبات مشمولة',
            ]),
            'includes_en' => json_encode([
                'Round-trip transportation from Al-Madinah',
                'Certified tour guide at archaeological sites',
                'All main meals (dinner, breakfast, lunch)',
                'Desert camping experience',
                'Activities and site entry fees',
                'Logistical support for the group',
            ]),
            'includes_ar' => json_encode([
                'المواصلات ذهابًا وعودة من المدينة المنورة',
                'مرشد سياحي معتمد في المواقع الأثرية',
                'جميع الوجبات الرئيسية',
                'تجربة التخييم الصحراوي',
                'رسوم الفعاليات والمواقع',
                'دعم لوجستي للمجموعة',
            ]),
            'itinerary_en' => 'AlUla Day Trip — Starting Point: Al-Madinah

⏰ Duration: 08:00 AM – 11:00 PM

🕗 08:00 AM – Departure from Al-Madinah
• Group gathers and departs by comfortable tourist bus.
• Enjoy scenic views along the route.

⸻

Noon
Arrival in AlUla & Head to Shabtraz Farm for lunch in nature
• Relaxed visit at Shabtraz Farm and resort activities.

Afternoon
Al-Maraya Theater (subject to availability)
• Visit Al-Maraya architectural icon (subject to availability).
• Time for photos and exploration.

Evening
Elephant Rock
• Stop at the famous natural landmark for photos and reflection.

Old Town
• Stroll the heritage alleys of the Old Town.
• Local shopping, coffee tasting and enjoying local arts.

🕚 11:00 PM – Return to Al-Madinah',
            'itinerary_ar' => 'رحلة العلا يوم واحد 📍 نقطة الانطلاق: المدينة المنورة

⏰ مدة الرحلة: من 8:00 صباحًا حتى 11:00 مساءً

🕗 08:00 صباحًا – الانطلاق من المدينة المنورة
• التجمع والانطلاق بسيارة باص سياحي مريح.
• الاستمتاع بالمناظر الطبيعية على طول الطريق.

⸻

ظهرًا
الوصول إلى العلا & والتوجة الى مزرعة شابترز
لتناول وجبة الغداء وسط الطبيعة
• جولة ممتعة في منتجع شلال،
• استكشاف الطبيعة والأنشطة المتوفرة.

عصرًا
مسرح مرايا (حسب التوافر)
• زيارة لأيقونة العلا المعمارية "مسرح مرايا".
• فرصة للتصوير والتعرف على المكان.

مساءً
جبل الفيل
• التوقف عند المعلم الطبيعي الشهير.
• وقت للتأمل والتقاط الصور.

البلدة القديمة
• جولة في أزقة البلدة القديمة التراثية.
• التسوق من المتاجر المحلية وتجربة القهوة والضيافة والاستمتاع بالفنون المصاحبه.

🕚 11:00 مساءً – العودة إلى المدينة المنورة',
        ]);

        // ============================================
        // Two Days AlUla Adventure (ID: 2)
        // ============================================
        IslandDestination::create([
            'slug' => 'alula-two-days',
            'title_en' => 'Two Days AlUla Adventure',
            'title_ar' => 'رحلة مبيت يومين للعلا',
            'type' => 'local',
            'type_en' => 'Heritage Tour',
            'description_en' => 'An unforgettable two-day journey through AlUla\'s most iconic sites. Experience the desert magic, discover ancient heritage, and immerse yourself in authentic Bedouin culture with professional guides and comfortable desert accommodations.',
            'description_ar' => 'رحلة ليلية مميزة لمدة يومين عبر أشهر المواقع في العلا. اختبر سحر الصحراء، واكتشف التراث القديم، وانغمس في الثقافة البدوية الأصلية مع مرشدين محترفين وإقامة صحراوية مريحة.',
            'duration_en' => '2 Days 1 Night',
            'duration_ar' => 'يومان ليلة واحدة',
            'groupSize_en' => '4-20 Persons',
            'groupSize_ar' => '4-20 أشخاص',
            'location_en' => 'AlUla, Saudi Arabia',
            'location_ar' => 'العلا، السعودية',
            'price' => 1800.00,
            'rating' => 4.7,
            'image' => null,
            'city_id' => $alula->id,
            'active' => true,
            'highlights_en' => json_encode(['Heritage Sites', 'Desert Camping', 'Ancient Tombs', 'Bedouin Culture']),
            'highlights_ar' => json_encode(['المواقع التراثية', 'التخييم الصحراوي', 'القبور القديمة', 'الثقافة البدوية']),
            'features' => json_encode([
                'Luxury desert lodge',
                'All meals & snacks',
                'Bedouin experience',
                'Professional guide',
                'Desert activities',
                'Photography service',
            ]),
            'features_ar' => json_encode([
                'منتجع صحراوي فاخر',
                'جميع الوجبات والوجبات الخفيفة',
                'تجربة بدوية',
                'مرشد احترافي',
                'أنشطة صحراوية',
                'خدمة التصوير',
            ]),
            'includes_en' => json_encode([
                'Round-trip transportation from Al-Madinah',
                'Luxury desert lodge accommodation',
                'Expert tour guide services',
                'All meals and premium snacks',
                'Bedouin cultural experience',
                'Hegra (UNESCO) site visit',
                'Al-Maraya Theater visit',
                'Professional photography service',
                'Desert safari activities',
                'Insurance coverage',
            ]),
            'includes_ar' => json_encode([
                'المواصلات ذهابًا وعودة من المدينة المنورة',
                'إقامة منتجع صحراوي فاخر',
                'خدمات مرشد سياحي خبير',
                'جميع الوجبات والوجبات الخفيفة المتميزة',
                'تجربة ثقافية بدوية',
                'زيارة موقع الحجر (اليونسكو)',
                'زيارة مسرح مرايا',
                'خدمة التصوير الاحترافي',
                'أنشطة سفاري صحراوي',
                'تغطية التأمين',
            ]),
            'itinerary_en' => 'Two-Day AlUla Overnight — Day One
• 08:00 AM – Departure from Al-Madinah (meeting and departure by comfortable coach)
• Scenic drive (approx. 3–4 hours)

— Arrival in AlUla & Head to Shabtraz Farm
• Lunch in nature and check-in to accommodation

Visit Shalal Resort
• Enjoyable resort tour and activities

Afternoon
— Al-Maraya Theater (subject to availability)
• Exterior visit to Al-Maraya + time for photos

Evening
— Elephant Rock
• Stop at the natural landmark + time for photos and reflection

— Old Town
• Walk the heritage alleys, local shopping, coffee and cultural experiences

— Return to camp (shared tents)
• Welcome, light dinner and campfire gathering
• Overnight in camp

Day Two • Hegra & Return
• Communal countryside breakfast at camp
• Morning adventure in AlUla\'s gullies and rock formations with selected photo stops (if not done on Day One)
• Visit Hegra (Mada\'in Saleh)
• Light lunch/rest (optional)

03:00 PM — Depart AlUla for Al-Madinah
06:30–07:00 PM — Arrival and trip closure',
            'itinerary_ar' => 'رحلة مبيت يومين للعلا
اليوم الأول — الوصول إلى العلا واكتشاف الأيقونات

— الانطلاق من المدينة المنورة الساعه 8:00 صباحاً
التجمع والانطلاق بباص سياحي مريح.
الاستمتاع بالمناظر الطبيعية على الطريق (مدة الطريق تقديريًا 3–4ساعات).

— الوصول إلى العلا & التوجّه إلى مزرعة شابترز.
غداء وسط الطبيعة.
استلام السكن.

زيارة منتجع شلال
جولة ممتعة في المنتجع وبين الجبال الساحرة.
استكشاف الطبيعة والأنشطة المتوفرة.

عصراً
— مسرح مرايا (حسب التوافر)
زيارة خارجية لأيقونة العلا المعمارية + وقت للتصوير.

مساءاُ
— جبل الفيل
توقف عند المعلم الطبيعي الشهير + وقت للتأمل والتصوير.

— البلدة القديمة
جولة بين الأزقة التراثية.
تسوق من المتاجر المحلية + قهوة وضيافة وفنون مصاحبة.

— العودة إلى المخيم (خيام مشتركة)
استقبال و عشاء خفيف وسمره حول النار.
مبيت في المخيم.
اليوم الثاني • الحجر • العودة

فطور ريفي جماعي في المخيم.

مغامرة صباحية في دهاليز العلا وتكويناتها الصخرية توقّفات تصوير مختارة.( اذا لم تمقام الفعاليه باليوم الاول) .
زيارة الحجر .

استراحة/غداء خفيف (اختياري حسب توافر الوقت)

03:00 م — الانطلاق من العلا عودةً إلى المدينة المنورة.
06:30–07:00 م — الوصول وختم الرحلة.
يشمل
باص سياحي مريح ذهابًا وإيابًا من المدينة المنورة.
مبيت ليلة واحدة في مخيم بخيم مشتركة.
تنظيم كامل للبرنامج مع مرشدين معتمدين في المواقع الأثرية.
زيارة منتجع شلال، جبل الفيل، البلدة القديمة، دهاليز العلا، وزيارة الحجر.
وجبة غداء اليوم الأول + فطور اليوم الثاني + ماء ووجبات خفيفة.
دعم لوجستي للمجموعة.
ملاحظات.
يُنصح بملابس مريحة للطقس الصحراوي وأحذية مناسبة للمشي.
يمكن ترقية الإقامة أو إضافة تصوير درون.',
        ]);

        // ============================================
        // Three Days AlUla Experience (ID: 3)
        // ============================================
        IslandDestination::create([
            'slug' => 'alula-three-days',
            'title_en' => 'Three Days AlUla Experience',
            'title_ar' => 'رحلة مبيت 3 ايام العلا',
            'type' => 'local',
            'type_en' => 'Heritage Experience',
            'description_en' => 'A comprehensive three-day exploration of AlUla\'s most significant heritage sites. Stay overnight in the heart of the desert, guided by local experts who reveal the secrets of ancient civilizations, Bedouin traditions, and desert wonders.',
            'description_ar' => 'استكشاف شامل لمدة ثلاثة أيام للمواقع التراثية الأكثر أهمية في العلا. استقم في قلب الصحراء، برفقة خبراء محليين يكشفون أسرار الحضارات القديمة والتقاليد البدوية وعجائب الصحراء.',
            'duration_en' => '3 Days 2 Nights',
            'duration_ar' => '3 أيام ليلتان',
            'groupSize_en' => '4-20 Persons',
            'groupSize_ar' => '4-20 أشخاص',
            'location_en' => 'AlUla, Saudi Arabia',
            'location_ar' => 'العلا، السعودية',
            'price' => 3200.00,
            'rating' => 4.8,
            'image' => null,
            'city_id' => $alula->id,
            'active' => true,
            'highlights_en' => json_encode(['Ancient Heritage Sites', 'Desert Camping', 'Star Gazing', 'Bedouin Culture']),
            'highlights_ar' => json_encode(['المواقع التراثية القديمة', 'التخييم الصحراوي', 'مراقبة النجوم', 'الثقافة البدوية']),
            'features' => json_encode([
                'Luxury desert lodge',
                'Expert guides',
                'Meals included',
                'Desert camping',
                'Star gazing',
                'Cultural experiences',
            ]),
            'features_ar' => json_encode([
                'منتجع صحراوي فاخر',
                'مرشدون خبراء',
                'الوجبات المشمولة',
                'تخييم صحراوي',
                'مراقبة النجوم',
                'تجارب ثقافية',
            ]),
            'includes_en' => json_encode([
                'Round-trip transportation from Al-Madinah',
                'Luxury desert lodge accommodation',
                'Expert archaeologist guide services',
                'All meals and premium refreshments',
                'Desert camping experience',
                'Hegra (UNESCO) site entry',
                'Al-Maraya Theater visit',
                'Professional photography service',
                'Insurance coverage',
            ]),
            'includes_ar' => json_encode([
                'المواصلات ذهابًا وعودة من المدينة المنورة',
                'إقامة منتجع صحراوي فاخر',
                'خدمات مرشد عالم آثار خبير',
                'جميع الوجبات والمشروبات المتميزة',
                'تجربة التخييم الصحراوي',
                'دخول موقع الحجر (اليونسكو)',
                'زيارة مسرح مرايا',
                'خدمة التصوير الاحترافي',
                'تغطية التأمين',
            ]),
            'itinerary_en' => 'Three Days in AlUla — Starting point: pickup at train station or airport; depart from Al-Madinah or meet at AlUla Airport
Duration: 3 days / 2 nights
Accommodation: camps and rural farms

— Day One
• 11:00 AM – Reception and departure from Al-Madinah
• 03:00 PM – Arrival in AlUla, check-in and lunch + rest
• 06:00 PM – Visit Elephant Rock and photo stop
• 07:00 PM – Visit Shalal Cafe
• 08:00 PM – Head to Shabtraz Farm:
  • Special dinner
  • Stargazing meditation session
  • Campfire music & evening
• 11:00 PM – Overnight

— Day Two
• 08:00 AM – Breakfast
• 09:30 AM – Head to booked activities (subject to booking):
  • Hegra tour
  • Dadan & Jabal Ikmah
  • Zipline experience
• 12:30 PM – Return to the farm for lunch + rest
• 04:00 PM – Visit Al-Maraya Theater (icon)
• 05:00 PM – Viewpoint and sunset
• 07:00 PM – Old Town tour + shopping and local experiences
• 11:00 PM – Return to camp and overnight

— Day Three
• 08:00 AM – Breakfast
• 09:30 AM – Head to natural experiences: dune driving or Wadi al-Naam
• 12:00 PM – Return to accommodation and check out
• 01:00 PM – Depart for Al-Madinah',
            'itinerary_ar' => 'رحلة مبيت ٣ ايام العلا 3 أيام في العلا

📍 نقطة الانطلاق: الاستقبال في محطة القطار او المطار والانطلاق من المدينة المنورة او الاستقبال في مطار العلا
🚌 مدة الرحلة: 3 أيام / ليلتين
🏕 الإقامة: مخيمات و مزارع ريفية

⸻

🗓 اليوم الأول
• 11:00 صباحًا – الاستقبال والانطلاق من المدينة المنورة.
• 03:00 عصرًا – الوصول إلى العلا والتوجه لاستلام السكن + وجبة الغداء + استراحة.
• 06:00 مساءً – زيارة جبل الفيل والتقاط الصور.
• 07:00 مساءً – التوجه إلى كافي شلال .
• 08:00 مساءً – التوجه الى مزرعة شابترز:
• عشاء مميز.
• جلسة تأمل النجوم.
• أمسية طربية على شبة النار.
• 11:00 ليلًا – المبيت.

⸻

🗓 اليوم الثاني
• 08:00 صباحًا – الإفطار.
• 09:30 صباحًا – التوجه إلى الفعاليات (حسب الحجز):
• جولة الحجر.
• جولة دادان وعكمة.
• تجربة الزبلاين.
• 12:30 ظهرًا – العودة إلى المزرعة لتناول الغداء + استراحة.
• 04:00 عصرًا – زيارة مسرح مرايا (أيقونة العلا).
• 05:00 مساءً – مطل الحرة + مشاهدة الغروب.
• 07:00 مساءً – جولة في البلدة القديمة + تسوق وتجارب محلية.
• 11:00 ليلًا – العودة إلى المخيم والمبيت.

⸻

🗓 اليوم الثالث
• 08:00 صباحًا – الإفطار.
• 09:30 صباحًا – التوجه إلى احد التجارب الطبيعية:
• دهاليز تجربة الجيوب المكشوفة (تطعيس)
• وادي النعام.
• 12:00 ظهرًا – العودة إلى السكن + تسليم المخيمات.
• 01:00 ظهرًا – الانطلاق عودة إلى المدينة المنورة.

⸻

🔹 يشمل البرنامج:
• المواصلات ذهابًا وعودة.
• حجوزات الفعاليات والمواقع السياحية.
• مرشد سياحي معتمد.
• جميع الوجبات الرئيسية.
• جلسة طربية + تجربة تأمل النجوم.',
        ]);

        $this->command->info('✅ Local Island Destinations seeded successfully with 3 AlUla trips!');
    }
}
