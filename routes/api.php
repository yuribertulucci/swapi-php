<?php

use App\Routing\Route;
use App\Http\Controller\Api\FilmController;
use App\Http\Controller\Api\PersonController;
use App\Http\Controller\Api\PlanetController;
use App\Http\Controller\Api\SpecieController;
use App\Http\Controller\Api\StarshipController;
use App\Http\Controller\Api\VehicleController;

Route::get('/test/', function () {
    return response()->json(['message' => 'API is working!']);
})->name('api.test');

Route::group(['prefix' => '/v1'], function () {
    Route::group('/films', function () {
        Route::get('/', [FilmController::class, 'index']);
        Route::get('/{id}', [FilmController::class, 'show']);
        Route::get('/search/', [FilmController::class, 'search']);
    });
    Route::group('/people', function () {
        Route::get('/', [PersonController::class, 'index']);
        Route::get('/{id}', [PersonController::class, 'show']);
        Route::get('/search/', [PersonController::class, 'search']);
    });
    Route::group('/planets', function () {
        Route::get('/', [PlanetController::class, 'index']);
        Route::get('/{id}', [PlanetController::class, 'show']);
        Route::get('/search/', [PlanetController::class, 'search']);
    });
    Route::group('/species', function () {
        Route::get('/', [SpecieController::class, 'index']);
        Route::get('/{id}', [SpecieController::class, 'show']);
        Route::get('/search/', [SpecieController::class, 'search']);
    });
    Route::group('/starships', function () {
        Route::get('/', [StarshipController::class, 'index']);
        Route::get('/{id}', [StarshipController::class, 'show']);
        Route::get('/search/', [StarshipController::class, 'search']);
    });
    Route::group('/vehicles', function () {
        Route::get('/', [VehicleController::class, 'index']);
        Route::get('/{id}', [VehicleController::class, 'show']);
        Route::get('/search/', [VehicleController::class, 'search']);
    });
});