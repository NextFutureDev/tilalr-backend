<?php

/**
 * Test Image Upload Configuration
 * This script helps diagnose image upload issues
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Storage;
use App\Models\IslandDestination;

// Setup Laravel App
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== IMAGE UPLOAD DIAGNOSTIC ===\n\n";

// 1. Check storage disks
echo "1. STORAGE CONFIGURATION:\n";
echo "   Default Disk: " . config('filesystems.default') . "\n";
echo "   Public Disk Root: " . config('filesystems.disks.public.root') . "\n";
echo "   Public Disk URL: " . config('filesystems.disks.public.url') . "\n";
echo "   APP_URL: " . config('app.url') . "\n\n";

// 2. Check if directories exist
echo "2. DIRECTORY CHECKS:\n";
$publicStoragePath = storage_path('app/public');
$islandsPath = $publicStoragePath . '/islands';
echo "   Storage/app/public exists: " . (is_dir($publicStoragePath) ? "YES" : "NO") . "\n";
echo "   Storage/app/public/islands exists: " . (is_dir($islandsPath) ? "YES" : "NO") . "\n";
echo "   Public/storage symlink exists: " . (is_link(public_path('storage')) ? "YES" : "NO") . "\n\n";

// 3. Check file permissions
echo "3. PERMISSIONS:\n";
echo "   Storage/app/public writable: " . (is_writable($publicStoragePath) ? "YES" : "NO") . "\n";
echo "   Storage/app/public/islands writable: " . (is_writable($islandsPath) ? "YES" : "NO") . "\n\n";

// 4. Check existing images in database
echo "4. EXISTING ISLANDS IN DATABASE:\n";
$islands = IslandDestination::where('type', 'local')->get();
foreach ($islands as $island) {
    echo "   - {$island->title_en} (ID: {$island->id})\n";
    echo "     Image path: " . ($island->image ?? 'NULL') . "\n";
    
    if ($island->image) {
        $fullPath = storage_path('app/public') . $island->image;
        echo "     File exists: " . (file_exists($fullPath) ? "YES" : "NO") . "\n";
        echo "     Full path: " . $fullPath . "\n";
        
        // Generate full URL
        $url = config('app.url') . '/storage' . $island->image;
        echo "     Full URL: " . $url . "\n";
    }
    echo "\n";
}

// 5. Check files in islands folder
echo "5. FILES IN ISLANDS FOLDER:\n";
$files = glob($islandsPath . '/*');
foreach ($files as $file) {
    if (is_file($file)) {
        echo "   - " . basename($file) . "\n";
    }
}

echo "\n=== RECOMMENDATIONS ===\n";

if (!is_link(public_path('storage'))) {
    echo "⚠️  Missing symlink! Run: php artisan storage:link\n";
} else {
    echo "✅ Storage symlink exists\n";
}

if (!is_writable($islandsPath)) {
    echo "⚠️  Islands folder not writable! Check permissions.\n";
} else {
    echo "✅ Islands folder is writable\n";
}

echo "\nTo test upload:\n";
echo "1. Go to: http://localhost:8000/admin\n";
echo "2. Edit an Island Destination\n";
echo "3. Upload an image in the 'Media & Status' section\n";
echo "4. Save and check this script output again\n";
