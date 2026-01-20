<?php
$s = file_get_contents('http://127.0.0.1:8000/admin/login');
file_put_contents(__DIR__ . '/admin_login_html.html', $s);
echo "Saved to tools/admin_login_html.html\n";
