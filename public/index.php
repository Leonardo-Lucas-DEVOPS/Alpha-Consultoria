<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require_once __DIR__ . '/../vendor/autoload.php';

// Bootstrap the application and handle the request...
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
