<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Seeder;

class NormalizeMediaPathsSeeder extends Seeder
{
    public function run(): void
    {
        $updated = 0;
        Trip::where('image', 'like', '/%')->get()->each(function ($t) use (&$updated) {
            $t->image = ltrim($t->image, '/');
            if ($t->video) {
                $t->video = ltrim($t->video, '/');
            }
            $t->save();
            $updated++;
        });

        $this->command->info("Normalized media paths for {$updated} trips.");
    }
}
