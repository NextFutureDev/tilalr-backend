<?php
$ch = curl_init('http://127.0.0.1:8000/admin/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
if ($res === false) { echo "Curl error: " . curl_error($ch) . PHP_EOL; exit(1); }
file_put_contents(__DIR__ . '/admin_login_full.html', $res);
echo "Saved to admin_login_full.html\n";
