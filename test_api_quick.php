<?php
// Simple verification - just check what the API returns
echo "=== Testing API Endpoints ===\n\n";

// Test international endpoint
echo "Testing: http://localhost:8000/api/island-destinations\n";
$intl = @file_get_contents('http://localhost:8000/api/island-destinations', false, stream_context_create(['http' => ['timeout' => 5]]));

if ($intl) {
    $data = json_decode($intl, true);
    if ($data && isset($data['data'])) {
        echo "✓ Success! Got " . count($data['data']) . " international islands\n";
        foreach ($data['data'] as $i => $island) {
            echo "  " . ($i+1) . ". {$island['title_en']}\n";
        }
    } else {
        echo "✗ Response not valid JSON or missing 'data' field\n";
        echo "Response: " . substr($intl, 0, 200) . "\n";
    }
} else {
    echo "✗ Could not fetch endpoint\n";
}

echo "\n";

// Test local endpoint
echo "Testing: http://localhost:8000/api/island-destinations/local\n";
$local = @file_get_contents('http://localhost:8000/api/island-destinations/local', false, stream_context_create(['http' => ['timeout' => 5]]));

if ($local) {
    $data = json_decode($local, true);
    if ($data && isset($data['data'])) {
        echo "✓ Success! Got " . count($data['data']) . " local islands\n";
        foreach ($data['data'] as $i => $island) {
            echo "  " . ($i+1) . ". {$island['title_en']}\n";
        }
    } else {
        echo "✗ Response not valid JSON or missing 'data' field\n";
        echo "Response: " . substr($local, 0, 200) . "\n";
    }
} else {
    echo "✗ Could not fetch endpoint\n";
}
?>
