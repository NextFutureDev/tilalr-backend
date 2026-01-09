<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class KeepOnlyWinterEvents extends Command
{
    protected $signature = 'winter:keep-only';

    protected $description = 'Delete ALL trips EXCEPT the 3 Winter Tilal & Sand events. Backs up removed data first.';

    public function handle(): int
    {
        $this->info('Backing up and removing all non-Winter-Tilal trips...');

        // Slugs to KEEP (Winter Tilal events only)
        $keepSlugs = [
            'winter-tilal-egyptian-night',
            'shatwiyat-tilal-layla-misriyya',
            'winter-tilal-founding-day',
            'yawm-al-tasis-shatwiyat-tilal',
            'winter-tilal-cultural-evening',
            'laylat-tarabi-shatwiyat-tilal',
        ];

        // Find ALL trips that are NOT in the keep list
        $toRemove = Trip::whereNotIn('slug', $keepSlugs)->get();

        if ($toRemove->isEmpty()) {
            $this->info('No trips to remove. Database already clean.');
            return 0;
        }

        // Backup removed trips
        $backupDir = storage_path('app/backups');
        if (! file_exists($backupDir)) mkdir($backupDir, 0755, true);
        $backupFile = $backupDir . DIRECTORY_SEPARATOR . 'all_other_trips_backup_' . date('Ymd_His') . '.json';
        file_put_contents($backupFile, json_encode($toRemove->map->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info("Backup saved to: {$backupFile}");

        // Delete all trips NOT in the keep list
        $deleted = 0;
        DB::transaction(function() use ($keepSlugs, &$deleted) {
            $deleted = Trip::whereNotIn('slug', $keepSlugs)->delete();
        });

        $this->info("✅ Deleted {$deleted} trip(s). Database now contains ONLY the 3 Winter Tilal & Sand events (6 records: EN + AR).");
        return 0;
    }
}
