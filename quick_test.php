<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$path = config('filesystems.disks.public.root') . '/islands';
echo "Islands folder: $path\n";
echo "Exists: " . (is_dir($path) ? 'YES' : 'NO') . "\n";
echo "Writable: " . (is_writable($path) ? 'YES' : 'NO') . "\n";
echo "Permissions: " . substr(sprintf('%o', fileperms($path)), -4) . "\n";

$testFile = $path . '/test_' . time() . '.jpg';
if (file_put_contents($testFile, 'test')) {
    echo "✅ File write works\n";
    unlink($testFile);
} else {
    echo "❌ File write FAILED\n";
}
