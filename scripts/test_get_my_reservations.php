<?php
// GET /api/my-reservations with Authorization header
$token = '14|pblnZKeOVh5NW1X7dUdRyy7A1EeLqNLWw31Jz5STc5d64b3e';
$url = 'http://127.0.0.1:8000/api/my-reservations';
$options = [
    'http' => [
        'header' => "Accept: application/json\r\nAuthorization: Bearer $token\r\n",
        'method' => 'GET',
        'ignore_errors' => true,
    ],
];
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo $result;
