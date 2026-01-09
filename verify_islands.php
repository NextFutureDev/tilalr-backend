<?php
// Simple verification script - no Laravel overhead
try {
    // MySQL connection
    $mysqli = new mysqli('localhost', 'root', '', 'tilrimal');
    
    if ($mysqli->connect_error) {
        die('DB Connection Failed: ' . $mysqli->connect_error);
    }
    
    echo "=== Island Destinations Count ===\n\n";
    
    // Count by type
    $result = $mysqli->query("SELECT type, COUNT(*) as cnt FROM island_destinations GROUP BY type");
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Type: {$row['type']} | Count: {$row['cnt']}\n";
        }
    } else {
        echo "No island destinations found in database!\n";
    }
    
    echo "\n=== International Islands Details ===\n";
    $intl = $mysqli->query("SELECT id, title_en, type, active FROM island_destinations WHERE type='island' LIMIT 10");
    if ($intl && $intl->num_rows > 0) {
        while ($row = $intl->fetch_assoc()) {
            echo "ID: {$row['id']} | Title: {$row['title_en']} | Active: {$row['active']}\n";
        }
    } else {
        echo "No international islands found!\n";
    }
    
    echo "\n=== Local Islands Details ===\n";
    $local = $mysqli->query("SELECT id, title_en, type, active FROM island_destinations WHERE type='local' LIMIT 10");
    if ($local && $local->num_rows > 0) {
        while ($row = $local->fetch_assoc()) {
            echo "ID: {$row['id']} | Title: {$row['title_en']} | Active: {$row['active']}\n";
        }
    } else {
        echo "No local islands found!\n";
    }
    
    // Test API response
    echo "\n=== Testing API Response ===\n";
    $json_intl = file_get_contents('http://localhost:8000/api/island-destinations');
    if ($json_intl) {
        $data = json_decode($json_intl, true);
        if (isset($data['data'])) {
            echo "International API returned " . count($data['data']) . " records\n";
        } else {
            echo "API Response: " . substr($json_intl, 0, 200) . "\n";
        }
    }
    
    $json_local = file_get_contents('http://localhost:8000/api/island-destinations/local');
    if ($json_local) {
        $data = json_decode($json_local, true);
        if (isset($data['data'])) {
            echo "Local API returned " . count($data['data']) . " records\n";
        } else {
            echo "Local API Response: " . substr($json_local, 0, 200) . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
