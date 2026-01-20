<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "config('app.key') => "; var_export(config('app.key')); echo PHP_EOL;
echo "env('APP_KEY') => "; var_export(env('APP_KEY')); echo PHP_EOL;
echo "getenv('APP_KEY') => "; var_export(getenv('APP_KEY')); echo PHP_EOL;
echo "php_sapi_name => " . php_sapi_name() . PHP_EOL;

// Also show parsed key via encryption service
try {
    $encrypter = $app->make('encrypter');
    echo "Encrypter present\n";
} catch (Exception $e) {
    echo "Encrypter error: " . get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}
