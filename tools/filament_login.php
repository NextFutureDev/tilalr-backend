<?php
// Simple Filament admin login test (uses cookies and CSRF token)
$base = 'http://127.0.0.1:8000';
$loginPage = $base . '/admin/login';
$cookieFile = sys_get_temp_dir() . '/filament_cookies.txt';

// 1) GET login page to get CSRF token and cookies
$ch = curl_init($loginPage);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
$res = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if ($res === false) { echo "Failed to fetch login page\n"; exit(1); }

// Extract CSRF token from meta tag: <meta name="csrf-token" content="..." />
if (preg_match('/<meta name="csrf-token" content="([^"]+)"\s*\/?>/i', $res, $m)) {
    $csrf = $m[1];
    echo "CSRF: $csrf\n";
} else {
    echo "CSRF token not found\n";
    // Try to find hidden input _token
    if (preg_match('/name="_token" value="([^"]+)"/i', $res, $m2)) {
        $csrf = $m2[1];
        echo "Found form _token: $csrf\n";
    } else {
        echo "Could not find CSRF token - proceeding without it\n";
        $csrf = '';
    }
}

// 2) POST credentials
$post = [
    'email' => 'superadmin@tilalr.com',
    'password' => 'superadmin123',
];
if ($csrf) $post['_token'] = $csrf;

$ch = curl_init($loginPage);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_HEADER, true);
$res = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "POST /admin/login -> HTTP/" . ($info['http_code'] ?? '??') . "\n";
if ($res) {
    // show redirect Location header if present
    if (preg_match('/Location:\s*(.*)\r\n/i', $res, $m)) {
        echo "Redirects to: " . trim($m[1]) . "\n";
    }
    echo substr($res, 0, 1000) . "\n";
}

// 3) Fetch /admin
$ch = curl_init($base . '/admin');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_HEADER, true);
$res = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "GET /admin -> HTTP/" . ($info['http_code'] ?? '??') . "\n";
if ($res) echo substr($res, 0, 1000) . "\n";

// Cleanup
@unlink($cookieFile);
