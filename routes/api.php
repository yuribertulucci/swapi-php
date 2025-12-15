<?php

use App\Routing\Route;
use App\Http\Controller\Api\FilmController;
use App\Http\Controller\Api\PersonController;

Route::get('/test/', function () {
    return response()->json(['message' => 'API is working!']);
})->name('api.test');

Route::get('/films/', [FilmController::class, 'index']);
Route::get('/films/{id}', [FilmController::class, 'show']);
Route::get('/films/search/', [FilmController::class, 'search']);
Route::get('/people/', [PersonController::class, 'index']);
Route::get('/people/{id}', [PersonController::class, 'show']);
Route::get('/people/search/', [PersonController::class, 'search']);