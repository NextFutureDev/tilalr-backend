<?php
// Direct database seeding script - no Laravel
$mysqli = new mysqli('localhost', 'root', '', 'tilrimal');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "=== Checking Island Destinations ===\n\n";

// Check if table exists
$tables = $mysqli->query("SHOW TABLES LIKE 'island_destinations'");
if ($tables->num_rows == 0) {
    die("ERROR: island_destinations table does not exist!\n");
}

// Count current records
$result = $mysqli->query("SELECT COUNT(*) as cnt FROM island_destinations");
$row = $result->fetch_assoc();
$currentCount = $row['cnt'];
echo "Current records in database: " . $currentCount . "\n\n";

// Show what's there
$existing = $mysqli->query("SELECT id, type, title_en FROM island_destinations");
if ($existing->num_rows > 0) {
    echo "Existing records:\n";
    while ($r = $existing->fetch_assoc()) {
        echo "  - ID {$r['id']}: {$r['title_en']} (type: {$r['type']})\n";
    }
    echo "\n";
} else {
    echo "No records found - will seed them now...\n\n";
}

// Get or create cities
echo "=== Creating/Checking Cities ===\n";

$cities = [
    ['name' => 'Jeddah', 'slug' => 'jeddah'],
    ['name' => 'Dammam', 'slug' => 'dammam'],
    ['name' => 'Jazan', 'slug' => 'jazan'],
    ['name' => 'Farasan', 'slug' => 'farasan'],
    ['name' => 'Umluj', 'slug' => 'umluj'],
    ['name' => 'Al Lith', 'slug' => 'al-lith'],
];

$cityMap = [];
foreach ($cities as $c) {
    $slug = $mysqli->real_escape_string($c['slug']);
    $name = $mysqli->real_escape_string($c['name']);
    
    $checkCity = $mysqli->query("SELECT id FROM cities WHERE slug = '$slug'");
    
    if ($checkCity->num_rows > 0) {
        $row = $checkCity->fetch_assoc();
        $cityMap[$c['slug']] = $row['id'];
        echo "✓ City exists: {$name} (ID: {$row['id']})\n";
    } else {
        // Create city
        $insertCity = $mysqli->query("INSERT INTO cities (name, slug, lang, is_active, created_at, updated_at) 
            VALUES ('$name', '$slug', 'en', 1, NOW(), NOW())");
        
        if ($insertCity) {
            $cityId = $mysqli->insert_id;
            $cityMap[$c['slug']] = $cityId;
            echo "✓ City created: {$name} (ID: {$cityId})\n";
        } else {
            echo "✗ Failed to create city: {$name}\n";
        }
    }
}

echo "\n=== Seeding International Islands ===\n";

// International islands
$intlIslands = [
    [
        'title_en' => 'Island near Jeddah',
        'title_ar' => 'جزيرة بالقرب من جدة',
        'description_en' => 'A beautiful island destination near Jeddah.',
        'description_ar' => 'وجهة جزيرة جميلة بالقرب من جدة.',
        'slug' => 'island-jeddah',
        'city_slug' => 'jeddah',
        'price' => 199.00,
        'rating' => 4.5,
        'type' => 'island',
        'image' => 'islands/example-jeddah.jpg'
    ],
    [
        'title_en' => 'Island near Dammam',
        'title_ar' => 'جزيرة بالقرب من الدمام',
        'description_en' => 'A beautiful island destination near Dammam.',
        'description_ar' => 'وجهة جزيرة جميلة بالقرب من الدمام.',
        'slug' => 'island-dammam',
        'city_slug' => 'dammam',
        'price' => 199.00,
        'rating' => 4.5,
        'type' => 'island',
        'image' => 'islands/example-dammam.jpg'
    ],
    [
        'title_en' => 'Island near Jazan',
        'title_ar' => 'جزيرة بالقرب من جازان',
        'description_en' => 'A beautiful island destination near Jazan.',
        'description_ar' => 'وجهة جزيرة جميلة بالقرب من جازان.',
        'slug' => 'island-jazan',
        'city_slug' => 'jazan',
        'price' => 199.00,
        'rating' => 4.5,
        'type' => 'island',
        'image' => 'islands/example-jazan.jpg'
    ],
];

foreach ($intlIslands as $island) {
    $title_en = $mysqli->real_escape_string($island['title_en']);
    $title_ar = $mysqli->real_escape_string($island['title_ar']);
    $desc_en = $mysqli->real_escape_string($island['description_en']);
    $desc_ar = $mysqli->real_escape_string($island['description_ar']);
    $slug = $mysqli->real_escape_string($island['slug']);
    $city_id = $cityMap[$island['city_slug']] ?? 1;
    $type = $island['type'];
    $price = $island['price'];
    $rating = $island['rating'];
    $image = $mysqli->real_escape_string($island['image']);
    $features = json_encode(['Snorkeling', 'Boat', 'Camping']);
    
    // Check if exists
    $check = $mysqli->query("SELECT id FROM island_destinations WHERE slug = '$slug'");
    
    if ($check->num_rows == 0) {
        $sql = "INSERT INTO island_destinations (title_en, title_ar, description_en, description_ar, slug, city_id, type, price, rating, image, features, active, created_at, updated_at) 
                VALUES ('$title_en', '$title_ar', '$desc_en', '$desc_ar', '$slug', $city_id, '$type', $price, $rating, '$image', '$features', 1, NOW(), NOW())";
        
        if ($mysqli->query($sql)) {
            echo "✓ Created: {$island['title_en']}\n";
        } else {
            echo "✗ Failed: {$island['title_en']} - " . $mysqli->error . "\n";
        }
    } else {
        echo "→ Already exists: {$island['title_en']}\n";
    }
}

echo "\n=== Seeding Local Islands ===\n";

// Local islands
$localIslands = [
    [
        'title_en' => 'Local island near Farasan',
        'title_ar' => 'جزيرة محلية بالقرب من فرسان',
        'description_en' => 'A beautiful local island near Farasan.',
        'description_ar' => 'وجهة جزيرة محلية بالقرب من فرسان.',
        'slug' => 'local-island-farasan',
        'city_slug' => 'farasan',
        'price' => 99.00,
        'rating' => 4.2,
        'type' => 'local',
        'image' => 'islands/local-farasan.jpg'
    ],
    [
        'title_en' => 'Local island near Umluj',
        'title_ar' => 'جزيرة محلية بالقرب من أملج',
        'description_en' => 'A beautiful local island near Umluj.',
        'description_ar' => 'وجهة جزيرة محلية بالقرب من أملج.',
        'slug' => 'local-island-umluj',
        'city_slug' => 'umluj',
        'price' => 99.00,
        'rating' => 4.2,
        'type' => 'local',
        'image' => 'islands/local-umluj.jpg'
    ],
    [
        'title_en' => 'Local island near Al Lith',
        'title_ar' => 'جزيرة محلية بالقرب من الليث',
        'description_en' => 'A beautiful local island near Al Lith.',
        'description_ar' => 'وجهة جزيرة محلية بالقرب من الليث.',
        'slug' => 'local-island-al-lith',
        'city_slug' => 'al-lith',
        'price' => 99.00,
        'rating' => 4.2,
        'type' => 'local',
        'image' => 'islands/local-al-lith.jpg'
    ],
];

foreach ($localIslands as $island) {
    $title_en = $mysqli->real_escape_string($island['title_en']);
    $title_ar = $mysqli->real_escape_string($island['title_ar']);
    $desc_en = $mysqli->real_escape_string($island['description_en']);
    $desc_ar = $mysqli->real_escape_string($island['description_ar']);
    $slug = $mysqli->real_escape_string($island['slug']);
    $city_id = $cityMap[$island['city_slug']] ?? 1;
    $type = $island['type'];
    $price = $island['price'];
    $rating = $island['rating'];
    $image = $mysqli->real_escape_string($island['image']);
    $features = json_encode(['Swimming', 'Snorkeling', 'Beach BBQ']);
    
    // Check if exists
    $check = $mysqli->query("SELECT id FROM island_destinations WHERE slug = '$slug'");
    
    if ($check->num_rows == 0) {
        $sql = "INSERT INTO island_destinations (title_en, title_ar, description_en, description_ar, slug, city_id, type, price, rating, image, features, active, created_at, updated_at) 
                VALUES ('$title_en', '$title_ar', '$desc_en', '$desc_ar', '$slug', $city_id, '$type', $price, $rating, '$image', '$features', 1, NOW(), NOW())";
        
        if ($mysqli->query($sql)) {
            echo "✓ Created: {$island['title_en']}\n";
        } else {
            echo "✗ Failed: {$island['title_en']} - " . $mysqli->error . "\n";
        }
    } else {
        echo "→ Already exists: {$island['title_en']}\n";
    }
}

echo "\n=== Final Verification ===\n";

// Final count by type
$intlCount = $mysqli->query("SELECT COUNT(*) as cnt FROM island_destinations WHERE type = 'island' AND active = 1")->fetch_assoc()['cnt'];
$localCount = $mysqli->query("SELECT COUNT(*) as cnt FROM island_destinations WHERE type = 'local' AND active = 1")->fetch_assoc()['cnt'];

echo "✓ International islands (active): {$intlCount}\n";
echo "✓ Local islands (active): {$localCount}\n";

if ($intlCount > 0 && $localCount > 0) {
    echo "\n✓ SUCCESS! Both carousels should now display.\n";
    echo "  - Refresh your browser page\n";
    echo "  - You should see both 'Discover the World' and 'Discover Unique Destinations' carousels\n";
} else {
    echo "\n✗ WARNING: Data might still be missing. Check the database.\n";
}

$mysqli->close();
?>
