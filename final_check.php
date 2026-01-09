<?php
// Test API endpoints directly
$intl_url = 'http://localhost:8000/api/island-destinations';
$local_url = 'http://localhost:8000/api/island-destinations/local';

echo "Testing API Endpoints:\n\n";

echo "1. Testing International: $intl_url\n";
$intl = @file_get_contents($intl_url);
if ($intl) {
    $data = json_decode($intl, true);
    if (isset($data['data'])) {
        echo "   ✓ Success: " . count($data['data']) . " international islands\n";
        foreach ($data['data'] as $island) {
            echo "     - {$island['title_en']} (active: {$island['active']})\n";
        }
    } else {
        echo "   ✗ Invalid response\n";
    }
} else {
    echo "   ✗ Could not fetch\n";
}

echo "\n2. Testing Local: $local_url\n";
$local = @file_get_contents($local_url);
if ($local) {
    $data = json_decode($local, true);
    if (isset($data['data'])) {
        echo "   ✓ Success: " . count($data['data']) . " local islands\n";
        foreach ($data['data'] as $island) {
            echo "     - {$island['title_en']} (active: {$island['active']})\n";
        }
    } else {
        echo "   ✗ Invalid response\n";
    }
} else {
    echo "   ✗ Could not fetch\n";
}

echo "\n\nDirect Database Check:\n";
$conn = new mysqli('localhost', 'root', '', 'tilrimal');

echo "\nInternational islands in DB:\n";
$result = $conn->query("SELECT COUNT(*) as cnt FROM island_destinations WHERE type='island' AND active=1");
$row = $result->fetch_assoc();
echo "Count: " . $row['cnt'] . "\n";

$islands = $conn->query("SELECT id, title_en, type, active FROM island_destinations WHERE type='island'");
while ($row = $islands->fetch_assoc()) {
    echo "  - {$row['title_en']} (ID: {$row['id']}, active: {$row['active']})\n";
}

echo "\nLocal islands in DB:\n";
$result = $conn->query("SELECT COUNT(*) as cnt FROM island_destinations WHERE type='local' AND active=1");
$row = $result->fetch_assoc();
echo "Count: " . $row['cnt'] . "\n";

$islands = $conn->query("SELECT id, title_en, type, active FROM island_destinations WHERE type='local'");
while ($row = $islands->fetch_assoc()) {
    echo "  - {$row['title_en']} (ID: {$row['id']}, active: {$row['active']})\n";
}

$conn->close();
?>
