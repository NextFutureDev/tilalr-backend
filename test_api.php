<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/api/island-destinations?type=local', 'GET');
$response = $kernel->handle($request);
echo $response->getContent();
$kernel->terminate($request, $response);
