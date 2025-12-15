<?php

use App\Core\Application;

ini_set('display_errors', 1);

require dirname(__DIR__) . '/vendor/autoload.php';

Application::configure(dirname(__DIR__))
    ->withRouting(
        __DIR__ . '/../routes/web.php',
        __DIR__ . '/../routes/api.php'
    )
    ->withSingletons([
        \App\Routing\Router::class,
        \App\Http\Request::class,
    ])
    ->run();
