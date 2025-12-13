<?php

use App\Http\Controller\Api\FilmController as ApiFilmController;
use App\Http\Controller\PersonController;
use App\Http\Controller\Api\PersonController as ApiPersonController;
use App\Routing\Route;

Route::get('/api/test/', function () {
    return response()->json(['message' => 'API is working!']);
})->name('api.test');

Route::get('/api/films/', [ApiFilmController::class, 'index']);
Route::get('/api/films/{id}', [ApiFilmController::class, 'show']);
Route::get('/api/films/search/', [ApiFilmController::class, 'search']);
Route::get('/api/people/', [ApiPersonController::class, 'index']);
Route::get('/api/people/{id}', [ApiPersonController::class, 'show']);
Route::get('/api/people/search/', [ApiPersonController::class, 'search']);

return [
    # Web Routes
    '/people/' => [PersonController::class, 'index'],
    '/people/{id}/' => [PersonController::class, 'show'],
    '/test/' => function() {
        return response('This is a test route!');
    },
];