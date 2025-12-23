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
})->name('api.test')
    ->withMiddleware(\App\Middleware\LoggerMiddleware::class);

Route::group([
    'prefix' => '/v1',
    'middleware' => [
        \App\Middleware\LoggerMiddleware::class,
    ],
], function () {
    Route::group('/films', function () {
        Route::get('/', [FilmController::class, 'index'])->name('api.films.index');
        Route::get('/{id}', [FilmController::class, 'show'])->name('api.films.show');
        Route::get('/search/', [FilmController::class, 'search'])->name('api.films.search');
    });
    Route::group('/people', function () {
        Route::get('/', [PersonController::class, 'index'])->name('api.people.index');
        Route::get('/{id}', [PersonController::class, 'show'])->name('api.people.show');
        Route::get('/search/', [PersonController::class, 'search'])->name('api.people.search');
    });
    Route::group('/planets', function () {
        Route::get('/', [PlanetController::class, 'index'])->name('api.planets.index');
        Route::get('/{id}', [PlanetController::class, 'show'])->name('api.planets.show');
        Route::get('/search/', [PlanetController::class, 'search'])->name('api.planets.search');
    });
    Route::group('/species', function () {
        Route::get('/', [SpecieController::class, 'index'])->name('api.species.index');
        Route::get('/{id}', [SpecieController::class, 'show'])->name('api.species.show');
        Route::get('/search/', [SpecieController::class, 'search'])->name('api.species.search');
    });
    Route::group('/starships', function () {
        Route::get('/', [StarshipController::class, 'index'])->name('api.starships.index');
        Route::get('/{id}', [StarshipController::class, 'show'])->name('api.starships.show');
        Route::get('/search/', [StarshipController::class, 'search'])->name('api.starships.search');
    });
    Route::group('/vehicles', function () {
        Route::get('/', [VehicleController::class, 'index'])->name('api.vehicles.index');
        Route::get('/{id}', [VehicleController::class, 'show'])->name('api.vehicles.show');
        Route::get('/search/', [VehicleController::class, 'search'])->name('api.vehicles.search');
    });
});