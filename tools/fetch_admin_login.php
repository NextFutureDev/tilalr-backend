<?php
$ch = curl_init('http://127.0.0.1:8000/admin/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
echo "HTTP/".$info['http_version']." " . ($info['http_code'] ?? '??') . PHP_EOL;
if ($res) { echo substr($res,0,2000) . PHP_EOL; } else { echo "No body" . PHP_EOL; }
