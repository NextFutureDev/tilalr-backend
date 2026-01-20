<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Training;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainings = [
            [
                'name' => 'Environmental Impact Assessment',
                'name_ar' => 'تقييم الأثر البيئي',
                'short_description' => 'Learn comprehensive environmental impact assessment methodologies and best practices for regulatory compliance.',
                'short_description_ar' => 'تعلم منهجيات تقييم الأثر البيئي الشاملة وأفضل الممارسات للامتثال التنظيمي.',
                'description' => '<h3>Course Overview</h3><p>This comprehensive training program covers all aspects of Environmental Impact Assessment (EIA) including:</p><ul><li>Legal and regulatory frameworks</li><li>Assessment methodologies</li><li>Data collection and analysis</li><li>Stakeholder engagement</li><li>Report writing and presentation</li></ul><p>Perfect for environmental consultants, project managers, and regulatory professionals.</p>',
                'description_ar' => '<h3>نظرة عامة على الدورة</h3><p>يغطي برنامج التدريب الشامل هذا جميع جوانب تقييم الأثر البيئي بما في ذلك:</p><ul><li>الأطر القانونية والتنظيمية</li><li>منهجيات التقييم</li><li>جمع البيانات والتحليل</li><li>مشاركة أصحاب المصلحة</li><li>كتابة التقارير والعرض</li></ul><p>مثالي للمستشارين البيئيين ومديري المشاريع والمهنيين التنظيميين.</p>',
                'slug' => 'environmental-impact-assessment'
            ],
            [
                'name' => 'Meteorological Data Analysis',
                'name_ar' => 'تحليل البيانات الأرصادية',
                'short_description' => 'Master weather data collection, analysis, and interpretation techniques for accurate forecasting.',
                'short_description_ar' => 'أتقن تقنيات جمع وتحليل وتفسير بيانات الطقس للتنبؤ الدقيق.',
                'description' => '<h3>Course Overview</h3><p>Advanced training in meteorological data analysis covering:</p><ul><li>Weather station setup and maintenance</li><li>Data quality control</li><li>Statistical analysis methods</li><li>Climate modeling basics</li><li>Forecasting techniques</li></ul><p>Ideal for meteorologists, climate researchers, and environmental scientists.</p>',
                'description_ar' => '<h3>نظرة عامة على الدورة</h3><p>تدريب متقدم في تحليل البيانات الأرصادية يغطي:</p><ul><li>إعداد وصيانة محطات الطقس</li><li>مراقبة جودة البيانات</li><li>طرق التحليل الإحصائي</li><li>أساسيات نمذجة المناخ</li><li>تقنيات التنبؤ</li></ul><p>مثالي للأرصاديين وباحثي المناخ وعلماء البيئة.</p>',
                'slug' => 'meteorological-data-analysis'
            ],
            [
                'name' => 'Sustainable Development Planning',
                'name_ar' => 'تخطيط التنمية المستدامة',
                'short_description' => 'Develop skills in creating sustainable development strategies and implementation plans for long-term success.',
                'short_description_ar' => 'طور مهارات إنشاء استراتيجيات التنمية المستدامة وخطط التنفيذ للنجاح على المدى الطويل.',
                'description' => '<h3>Course Overview</h3><p>Comprehensive training in sustainable development planning including:</p><ul><li>Sustainability frameworks and principles</li><li>Stakeholder mapping and engagement</li><li>Resource management strategies</li><li>Monitoring and evaluation systems</li><li>Case studies and best practices</li></ul><p>Designed for urban planners, policy makers, and development professionals.</p>',
                'description_ar' => '<h3>نظرة عامة على الدورة</h3><p>تدريب شامل في تخطيط التنمية المستدامة يشمل:</p><ul><li>أطر ومبادئ الاستدامة</li><li>رسم خرائط أصحاب المصلحة والمشاركة</li><li>استراتيجيات إدارة الموارد</li><li>أنظمة المراقبة والتقييم</li><li>دراسات الحالة وأفضل الممارسات</li></ul><p>مصمم لمخططي المدن وصناع السياسات ومهنيي التنمية.</p>',
                'slug' => 'sustainable-development-planning'
            ]
        ];

        foreach ($trainings as $trainingData) {
            Training::create($trainingData);
        }
    }
}
