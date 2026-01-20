<?php
$ch = curl_init('http://127.0.0.1:8000/api/register');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = [
    'name' => 'Test Normal User',
    'phone' => '0559999999',
    'password' => 'testpass123',
    'password_confirmation' => 'testpass123'
];
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
$res = curl_exec($ch);
if ($res === false) { echo "Curl error: " . curl_error($ch) . PHP_EOL; exit(1); }
curl_close($ch);
echo "Response:\n" . $res . PHP_EOL;
