<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Seeder;

class UpdateTripTranslationsSeeder extends Seeder
{
    public function run(): void
    {
        $trips = Trip::all();

        foreach ($trips as $trip) {
            $titleTrans = $trip->title_trans ?? [];
            $descriptionTrans = $trip->description_trans ?? [];
            $contentTrans = $trip->content_trans ?? [];

            // Use existing `lang` to seed the correct key
            if ($trip->lang === 'en') {
                $titleTrans['en'] = $trip->title;
                $descriptionTrans['en'] = $trip->description;
                $contentTrans['en'] = $trip->content;
            } else if ($trip->lang === 'ar') {
                $titleTrans['ar'] = $trip->title;
                $descriptionTrans['ar'] = $trip->description;
                $contentTrans['ar'] = $trip->content;
            }

            // Persist only if changed
            $trip->title_trans = $titleTrans;
            $trip->description_trans = $descriptionTrans;
            $trip->content_trans = $contentTrans;
            $trip->save();
        }
    }
}
