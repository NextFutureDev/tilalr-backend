<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutSection;

class AboutSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutSection::create([
            'title_en' => "We've got what you need!",
            'title_ar' => "لدينا ما تحتاجه!",
            'paragraph_en' => "Sensing Nature delivers a complete range of innovative geological and geophysical solutions, from seismic and electrical surveys to advanced geological modeling. Our services are designed to provide accurate and reliable data, empowering you to make strategic decisions for your projects.",
            'paragraph_ar' => "تقدم سينسينج نيتشر مجموعة شاملة من الحلول الجيولوجية والجيوفيزيائية المبتكرة، من المسوحات الزلزالية والكهربائية إلى النمذجة الجيولوجية المتقدمة. خدماتنا مصممة لتوفير بيانات دقيقة وموثوقة، مما يمكنك من اتخاذ قرارات استراتيجية لمشاريعك.",
            'mission_title_en' => "Our Mission",
            'mission_title_ar' => "مهمتنا",
            'mission_paragraph_en' => "Providing distinguished and accurate consulting, development, engineering, meteorological and environmental services by providing innovative solutions to complex challenges using the best competencies, methods and scientific means in order to achieve leadership and excellence in the KSA, the Arab Gulf countries and the Middle East.",
            'mission_paragraph_ar' => "تقديم خدمات استشارية وتطويرية وهندسية و meteorology وبيئية متميزة ودقيقة من خلال تقديم حلول مبتكرة للتحديات المعقدة باستخدام أفضل الكفاءات والطرق والوسائل العلمية لتحقيق القيادة والتميز في المملكة العربية السعودية ودول الخليج العربي والشرق الأوسط.",
            'vision_title_en' => "Our Vision",
            'vision_title_ar' => "رؤيتنا",
            'vision_paragraph_en' => "Facilitate decision-making for entities and individuals by providing accurate and reliable information.",
            'vision_paragraph_ar' => "تسهيل اتخاذ القرارات للكيانات والأفراد من خلال توفير معلومات دقيقة وموثوقة.",
            'is_active' => true,
        ]);
    }
}
