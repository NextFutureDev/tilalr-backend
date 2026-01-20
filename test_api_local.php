<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate API call
$controller = new \App\Http\Controllers\Api\IslandDestinationController();
$request = new \Illuminate\Http\Request();
$request->query->set('type', 'local');

// Get the response
$response = $controller->index($request);
$data = json_decode($response->getContent(), true);

echo "=== API RESPONSE FOR /api/island-destinations?type=local ===\n\n";
echo "Success: " . ($data['success'] ? 'YES ✓' : 'NO ✗') . "\n";
echo "Count: " . count($data['data']) . " destinations\n";
echo "Message: " . $data['message'] . "\n\n";

foreach ($data['data'] as $dest) {
    echo "---\n";
    echo "Title: {$dest['title_en']}\n";
    echo "Price: {$dest['price']}\n";
    echo "Type: {$dest['type']}\n";
    echo "Image URL: {$dest['image']}\n";
    echo "---\n\n";
}
?>
