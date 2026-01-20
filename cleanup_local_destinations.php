<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Delete all local destinations except the 3 AlUla ones
$keep_slugs = ['trip-to-alula', 'alula-two-days', 'alula-three-days'];
$deleted = \App\Models\IslandDestination::where('type', 'local')
    ->whereNotIn('slug', $keep_slugs)
    ->delete();

echo "✅ Deleted $deleted old local destinations\n";
echo "✅ Kept only 3 AlUla trips\n";

$remaining = \App\Models\IslandDestination::where('type', 'local')->count();
echo "✅ Final count: $remaining local destinations\n";
?>
