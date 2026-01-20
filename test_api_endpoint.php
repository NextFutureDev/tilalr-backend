<?php

// Test API endpoint directly
$url = 'http://127.0.0.1:8000/api/login';
$data = [
    'email' => 'superadmin@tilalr.com',
    'password' => '439c0912efaa4ebf'
];

$options = [
    'http' => [
        'header' => [
            'Content-type: application/json',
            'Accept: application/json'
        ],
        'method' => 'POST',
        'content' => json_encode($data)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    echo "ERROR: Failed to connect to API\n";
    var_dump($http_response_header);
} else {
    echo "API Response:\n";
    $response = json_decode($result, true);
    print_r($response);
}