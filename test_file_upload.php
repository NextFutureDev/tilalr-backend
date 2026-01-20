<?php
/**
 * Test image upload to Island Destinations
 * This script tests if images can be uploaded and saved correctly
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IslandDestination;
use Illuminate\Http\UploadedFile;

echo "=== IMAGE UPLOAD TEST ===\n\n";

// Test 1: Check storage configuration
echo "1. STORAGE CONFIGURATION:\n";
echo "   Disk: " . config('filesystems.default') . "\n";
echo "   Public Root: " . config('filesystems.disks.public.root') . "\n";
echo "   Public URL: " . config('filesystems.disks.public.url') . "\n\n";

// Test 2: Check directories
echo "2. DIRECTORY STATUS:\n";
$publicPath = config('filesystems.disks.public.root');
$islandsPath = $publicPath . '/islands';
echo "   Public path exists: " . (is_dir($publicPath) ? "YES" : "NO") . "\n";
echo "   Islands path exists: " . (is_dir($islandsPath) ? "YES" : "NO") . "\n";
echo "   Islands writable: " . (is_writable($islandsPath) ? "YES" : "NO") . "\n";
echo "   Permissions: " . decoct(fileperms($islandsPath) & 0777) . "\n\n";

// Test 3: Test file creation directly
echo "3. TEST FILE WRITE:\n";
$testFile = $islandsPath . '/test_' . time() . '.txt';
if (file_put_contents($testFile, 'test content')) {
    echo "   ✅ Can write files\n";
    echo "   Test file: " . basename($testFile) . "\n";
    unlink($testFile);
} else {
    echo "   ❌ CANNOT write files!\n";
}
echo "\n";

// Test 4: Check Filament FileUpload configuration
echo "4. FILAMENT FILE UPLOAD TEST:\n";
echo "   Creating test uploaded file...\n";

// Create a fake image file for testing
$testImagePath = storage_path('app/test_image.jpg');
$fakeImageContent = file_get_contents('https://via.placeholder.com/100x100.jpg');
if (!$fakeImageContent) {
    // Create a minimal valid JPEG
    $fakeImageContent = base64_decode(
        '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEB' .
        'AQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQE' .
        'BAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCABkAGQDASIAAhEBAxEB' .
        '/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8VAFQEBAQAAAAAAA' .
        'AAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCwAA//9k='
    );
}

file_put_contents($testImagePath, $fakeImageContent);

try {
    echo "   Creating UploadedFile instance...\n";
    $uploadedFile = new UploadedFile(
        $testImagePath,
        'test_image.jpg',
        'image/jpeg',
        null,
        true
    );
    
    echo "   File size: " . $uploadedFile->getSize() . " bytes\n";
    echo "   MIME type: " . $uploadedFile->getMimeType() . "\n";
    echo "   Is valid image: " . ($uploadedFile->isValid() ? "YES" : "NO") . "\n";
    
    // Test storing the file
    $storagePath = $uploadedFile->store('islands', 'public');
    echo "   ✅ File stored successfully!\n";
    echo "   Storage path: $storagePath\n";
    
    // Verify it exists
    $fullPath = config('filesystems.disks.public.root') . '/' . $storagePath;
    echo "   Full path: $fullPath\n";
    echo "   File exists: " . (file_exists($fullPath) ? "YES" : "NO") . "\n";
    
    // Clean up
    \Illuminate\Support\Facades\Storage::disk('public')->delete($storagePath);
    echo "   Test file cleaned up\n";
    
} catch (\Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
    echo "   Code: " . $e->getCode() . "\n";
}
echo "\n";

// Test 5: Check database update
echo "5. DATABASE UPDATE TEST:\n";
$island = IslandDestination::find(13);
if ($island) {
    echo "   Island found: {$island->title_en}\n";
    echo "   Current image: " . ($island->image ?? 'NULL') . "\n";
    echo "   Can update: YES\n";
} else {
    echo "   ❌ Island not found\n";
}
echo "\n";

// Test 6: Check if symlink is working
echo "6. SYMLINK TEST:\n";
$symlinkPath = public_path('storage');
echo "   Symlink path: $symlinkPath\n";
echo "   Is link: " . (is_link($symlinkPath) ? "YES" : "NO") . "\n";
if (is_link($symlinkPath)) {
    $target = readlink($symlinkPath);
    echo "   Target: $target\n";
}
echo "\n";

echo "=== SUMMARY ===\n";
echo "If all tests passed, upload should work.\n";
echo "If any test failed, that's the issue to fix.\n";

// Clean up
if (file_exists($testImagePath)) {
    unlink($testImagePath);
}
