<?php
// Quick script to create test users
exec('cd ' . escapeshellarg(__DIR__) . ' && php artisan tinker --execute="
$users = [
    [\'name\' => \'Executive Manager\', \'email\' => \'executive@example.com\', \'password\' => \'password123\'],
    [\'name\' => \'Consultant\', \'email\' => \'consultant@example.com\', \'password\' => \'password123\'],
    [\'name\' => \'Admin User\', \'email\' => \'admin@example.com\', \'password\' => \'password123\'],
];
foreach(\$users as \$u) {
    \App\Models\User::updateOrCreate([\'email\' => \$u[\'email\']], [
        \'name\' => \$u[\'name\'],
        \'password\' => Hash::make(\$u[\'password\']),
        \'is_admin\' => false
    ]);
    echo \'Created: \' . \$u[\'email\'] . PHP_EOL;
}
"', $output, $exitCode);

echo implode("\n", $output);
echo "\nExit code: " . $exitCode;
