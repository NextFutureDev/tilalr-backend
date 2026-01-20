<?php
/**
 * Test login endpoint
 * Access at: http://localhost:8000/test_login.php
 */

header('Content-Type: application/json');

$credentials = [
    'executive' => ['email' => 'executive@example.com', 'password' => 'password123'],
    'consultant' => ['email' => 'consultant@example.com', 'password' => 'password123'],
    'admin' => ['email' => 'admin@example.com', 'password' => 'password123'],
];

$results = [];

foreach ($credentials as $type => $cred) {
    $ch = curl_init('http://127.0.0.1:8000/api/login');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($cred));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    $results[$type] = [
        'http_code' => $httpCode,
        'response' => $data,
    ];
}

echo json_encode($results, JSON_PRETTY_PRINT);
?>
