#!/usr/bin/env php
<?php
/**
 * Island Destinations Quick Test Script
 * Usage: php test_island_api.php
 */

echo "=== Island Destinations API Test ===\n\n";

// Test 1: Database connection
echo "1. Testing Database Connection...\n";
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=tilrimal',
        'root',
        ''
    );
    echo "✅ Database connected successfully\n\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 2: Check if table exists and has data
echo "2. Checking island_destinations table...\n";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM island_destinations WHERE type = 'local'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'] ?? 0;
    
    if ($count > 0) {
        echo "✅ Found $count local island destinations\n\n";
    } else {
        echo "⚠️  No local island destinations found\n";
        echo "   Run: php artisan db:seed --class=IslandDestinationsLocalSeeder\n\n";
    }
} catch (Exception $e) {
    echo "❌ Error checking table: " . $e->getMessage() . "\n";
}

// Test 3: Check specific fields
echo "3. Sample Data from Database:\n";
try {
    $stmt = $pdo->query("
        SELECT id, slug, title_en, price, image, type 
        FROM island_destinations 
        WHERE type = 'local' 
        LIMIT 1
    ");
    $dest = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($dest) {
        echo "ID: " . ($dest['id'] ?? 'N/A') . "\n";
        echo "Slug: " . ($dest['slug'] ?? 'N/A') . "\n";
        echo "Title: " . ($dest['title_en'] ?? 'N/A') . "\n";
        echo "Price: " . ($dest['price'] ?? 'N/A') . "\n";
        echo "Image: " . ($dest['image'] ?? 'N/A') . "\n";
        echo "Type: " . ($dest['type'] ?? 'N/A') . "\n\n";
    }
} catch (Exception $e) {
    echo "❌ Error fetching data: " . $e->getMessage() . "\n";
}

// Test 4: Check API endpoint via CLI
echo "4. Testing API Response...\n";
echo "   Make sure backend is running: php artisan serve --host=127.0.0.1 --port=8000\n";
echo "   Then test: curl http://127.0.0.1:8000/api/island-destinations/local\n\n";

// Test 5: Frontend .env check
echo "5. Frontend Environment Check:\n";
$envPath = 'tilrimal-frontend\\.env.local';
if (file_exists($envPath)) {
    echo "✅ .env.local found\n";
    $content = file_get_contents($envPath);
    if (strpos($content, 'NEXT_PUBLIC_API_URL') !== false) {
        echo "✅ NEXT_PUBLIC_API_URL is set\n\n";
    } else {
        echo "⚠️  NEXT_PUBLIC_API_URL not found in .env.local\n";
        echo "   Add: NEXT_PUBLIC_API_URL=http://127.0.0.1:8000/api\n\n";
    }
} else {
    echo "⚠️  .env.local not found\n";
    echo "   Create: tilrimal-frontend\\.env.local\n";
    echo "   Add: NEXT_PUBLIC_API_URL=http://127.0.0.1:8000/api\n\n";
}

echo "=== Test Complete ===\n";
?>
