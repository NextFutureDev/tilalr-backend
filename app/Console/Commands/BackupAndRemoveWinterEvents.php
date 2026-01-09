<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Trip;

class BackupAndRemoveWinterEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'winter:backup-remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup specific winter event trips to JSON and remove them from the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting backup of winter events...');

        $slugs = [
            'egyptian-night-winter-tilal',
            'egyptian-night-winter-tilal-ar',
            'founding-day-winter-tilal',
            'founding-day-winter-tilal-ar',
            'cultural-evening-winter-tilal',
            'cultural-evening-winter-tilal-ar',
        ];

        $trips = Trip::whereIn('slug', $slugs)->get();

        if ($trips->isEmpty()) {
            $this->info('No matching trips found for the provided slugs. Nothing to do.');
            return 0;
        }

        $backupDir = storage_path('app/backups');
        if (! file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $backupFile = $backupDir . DIRECTORY_SEPARATOR . 'winter_events_backup_' . date('Ymd_His') . '.json';

        try {
            file_put_contents($backupFile, json_encode($trips->map->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->info("Backup written to: {$backupFile}");

            $deletedCount = 0;

            DB::transaction(function () use ($slugs, &$deletedCount) {
                $deletedCount = Trip::whereIn('slug', $slugs)->delete();
            });

            $this->info("Deleted {$deletedCount} trip(s) matching the target slugs.");
            return 0;
        } catch (\Throwable $e) {
            $this->error('Error during backup or deletion: ' . $e->getMessage());
            return 1;
        }
    }
}
