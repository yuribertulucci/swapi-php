<?php

use App\Routing\Router;

ini_set('display_errors', 1);

require dirname(__DIR__) . '/vendor/autoload.php';

$routes = require dirname(__DIR__) . '/config/routes.php';
$router = Router::instance();
$router->loadRoutes($routes);

ob_start();
$router->handleRequest(request());
ob_end_flush();