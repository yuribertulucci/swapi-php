<?php

return [
    'driver' => env('DB_DRIVER', 'mysql'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'username' => env('DB_USER', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'database' => env('DB_NAME', 'app_database'),
];