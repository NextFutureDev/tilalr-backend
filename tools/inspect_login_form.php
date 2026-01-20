<?php
$url = 'http://127.0.0.1:8000/admin/login';
$opts = ['http'=>['method'=>'GET','header'=>'User-Agent: CLI']];
$ctx = stream_context_create($opts);
$html = @file_get_contents($url, false, $ctx);
if ($html === false) { echo "Failed to fetch $url\n"; exit(1); }

// Extract form tag and related JS
if (preg_match('/(<form[\s\S]*?<\/form>)/i', $html, $m)) {
    echo "FORM:\n" . $m[1] . "\n\n";
} else {
    echo "No <form> tag found.\n";
}

// List scripts that mention livewire or login
if (preg_match_all('/<script[^>]*>([\s\S]*?)<\/script>/i', $html, $scripts)) {
    foreach ($scripts[1] as $script) {
        if (stripos($script, 'livewire') !== false || stripos($script, 'login') !== false) {
            echo "SCRIPT SNIPPET:\n" . substr(trim($script), 0, 1000) . "\n\n";
        }
    }
}

// show meta and hidden csrf
if (preg_match('/<meta name="csrf-token" content="([^"]+)"/i', $html, $m2)) {
    echo "CSRF META: " . $m2[1] . "\n";
}
if (preg_match('/name="_token" value="([^"]+)"/i', $html, $m3)) {
    echo "FORM _token: " . $m3[1] . "\n";
}
