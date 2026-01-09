<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IslandDestination;
use App\Models\City;
use Illuminate\Support\Facades\Schema;

class IslandDestinationsLocalSeeder extends Seeder
{
    public function run()
    {
        $locals = [
            ['name' => 'Farasan', 'slug' => 'farasan'],
            ['name' => 'Umluj', 'slug' => 'umluj'],
            ['name' => 'Al Lith', 'slug' => 'al-lith'],
        ];

        foreach ($locals as $c) {
            $city = City::firstOrCreate(['slug' => $c['slug']], ['name' => $c['name'], 'lang' => 'en', 'is_active' => true]);

            $attributes = ['title_en' => "Local island near {$city->name}"];
            if (Schema::hasColumn('island_destinations', 'city_id')) {
                $attributes['city_id'] = $city->id;
            }

            if (Schema::hasColumn('island_destinations', 'slug')) {
                $attributes['slug'] = 'local-island-' . $city->slug;
            }

            $values = [
                'title_ar' => "جزيرة محلية بالقرب من {$city->name}",
                'description_en' => "A beautiful local island near {$city->name}.",
                'description_ar' => "وجهة جزيرة محلية بالقرب من {$city->name}.",
                'features' => ['Swimming', 'Snorkeling', 'Beach BBQ'],
                'image' => 'islands/local-' . $city->slug . '.jpg',
                'price' => 99.00,
                'rating' => 4.2,
                'type' => 'local',
                'active' => true,
            ];

            IslandDestination::updateOrCreate($attributes, $values);
        }
    }
}
