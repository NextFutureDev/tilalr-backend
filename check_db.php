<?php
require __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$count = DB::table('island_destinations')->where('type', 'local')->count();
echo "Local destinations in database: " . $count . "\n";

if ($count > 0) {
    $destinations = DB::table('island_destinations')->where('type', 'local')->get();
    foreach ($destinations as $d) {
        echo "- " . $d->slug . " (" . $d->id . ")\n";
    }
} else {
    echo "⚠️  NO LOCAL DESTINATIONS FOUND - Database not seeded!\n";
}

exit(0);
