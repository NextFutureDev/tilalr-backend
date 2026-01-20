<?php
$token = $argv[1] ?? '';
if (!$token) { echo "Usage: php user_test.php <token>\n"; exit(1); }
$ch = curl_init('http://127.0.0.1:8000/api/user');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
$res = curl_exec($ch);
if ($res === false) { echo "Curl error: " . curl_error($ch) . PHP_EOL; exit(1); }
curl_close($ch);
echo $res . PHP_EOL;