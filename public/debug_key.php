<?php
// Lightweight debug endpoint (no Laravel bootstrap) to inspect .env & env vars
header('Content-Type: application/json');
$envPath = __DIR__ . '/../.env';
$envExists = file_exists($envPath);
$envContents = $envExists ? file_get_contents($envPath) : null;
$envFirst = $envExists ? substr($envContents, 0, 800) : null;

echo json_encode([
    'cwd' => getcwd(),
    'php_sapi' => php_sapi_name(),
    'php_version' => phpversion(),
    'env_file_exists' => $envExists,
    'env_first_chunk' => $envFirst,
    'getenv_APP_KEY' => getenv('APP_KEY'),
    'env_superglobal' => isset($_ENV['APP_KEY']) ? $_ENV['APP_KEY'] : null,
    'server_superglobal' => isset($_SERVER['APP_KEY']) ? $_SERVER['APP_KEY'] : null,
    'server_vars' => [
        'DOCUMENT_ROOT' => $_SERVER['DOCUMENT_ROOT'] ?? null,
        'SCRIPT_FILENAME' => $_SERVER['SCRIPT_FILENAME'] ?? null,
    ],
], JSON_PRETTY_PRINT);

