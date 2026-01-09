<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Seeder;

class SyncLegacyTitlesSeeder extends Seeder
{
    public function run(): void
    {
        $updated = 0;
        Trip::all()->each(function ($t) use (&$updated) {
            $changed = false;
            if (is_array($t->title_trans) && !empty($t->title_trans['en']) && $t->title !== $t->title_trans['en']) {
                $t->title = $t->title_trans['en'];
                $changed = true;
            }
            if (is_array($t->description_trans) && !empty($t->description_trans['en']) && $t->description !== $t->description_trans['en']) {
                $t->description = $t->description_trans['en'];
                $changed = true;
            }
            if ($changed) {
                $t->save();
                $updated++;
            }
        });

        $this->command->info("Synchronized legacy title/description for {$updated} trips.");
    }
}
