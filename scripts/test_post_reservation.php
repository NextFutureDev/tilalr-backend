<?php
// Simple POST request using file_get_contents to test API
$url = 'http://127.0.0.1:8000/api/reservations';
$data = [
    'name' => 'Test User',
    'email' => 'amanshah12@gmail.com',
    'phone' => '0551981751',
    'trip_type' => null,
    'trip_slug' => null,
    'trip_title' => 'Test Trip',
    'preferred_date' => null,
    'guests' => 2,
    'notes' => 'Test reservation via script',
    'details' => new stdClass(),
];
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\nAuthorization: Bearer 14|pblnZKeOVh5NW1X7dUdRyy7A1EeLqNLWw31Jz5STc5d64b3e\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true,
    ],
];
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo $result;
