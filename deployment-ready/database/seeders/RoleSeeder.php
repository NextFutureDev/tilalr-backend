<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'title_en' => 'CEO',
                'title_ar' => 'الرئيس التنفيذي',
                'description_en' => 'Chief Executive Officer',
                'description_ar' => 'الرئيس التنفيذي',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title_en' => 'CTO',
                'title_ar' => 'مدير التكنولوجيا',
                'description_en' => 'Chief Technology Officer',
                'description_ar' => 'مدير التكنولوجيا',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title_en' => 'Project Manager',
                'title_ar' => 'مدير المشاريع',
                'description_en' => 'Project Manager',
                'description_ar' => 'مدير المشاريع',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title_en' => 'Senior Geologist',
                'title_ar' => 'جيولوجي أول',
                'description_en' => 'Senior Geologist',
                'description_ar' => 'جيولوجي أول',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title_en' => 'Geophysicist',
                'title_ar' => 'جيوفيزيائي',
                'description_en' => 'Geophysicist',
                'description_ar' => 'جيوفيزيائي',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title_en' => 'Field Engineer',
                'title_ar' => 'مهندس ميداني',
                'description_en' => 'Field Engineer',
                'description_ar' => 'مهندس ميداني',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title_en' => 'Data Analyst',
                'title_ar' => 'محلل بيانات',
                'description_en' => 'Data Analyst',
                'description_ar' => 'محلل بيانات',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'title_en' => 'Research Scientist',
                'title_ar' => 'عالم أبحاث',
                'description_en' => 'Research Scientist',
                'description_ar' => 'عالم أبحاث',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
