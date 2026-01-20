<?php
$ch = curl_init('http://127.0.0.1:8000/api/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
$data = ['email' => 'superadmin@tilalr.com', 'password' => 'superadmin123'];
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$res = curl_exec($ch);
if ($res === false) {
    echo "Curl error: " . curl_error($ch) . PHP_EOL;
    exit(1);
}
curl_close($ch);
echo $res . PHP_EOL;