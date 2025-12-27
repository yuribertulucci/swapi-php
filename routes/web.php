<?php

use App\Routing\Route;

Route::get('/', function () {
   return view('home');
})->name('home');

Route::group('/films', function () {
    Route::get('/', [\App\Http\Controller\FilmController::class, 'index'])->name('films.index');
    Route::get('/{id}', [\App\Http\Controller\FilmController::class, 'show'])->name('films.show');
    Route::get('/search', [\App\Http\Controller\FilmController::class, 'search'])->name('films.search');
});

Route::group('/people', function () {
    Route::get('/', [\App\Http\Controller\PersonController::class, 'index'])->name('people.index');
    Route::get('/{id}', [\App\Http\Controller\PersonController::class, 'show'])->name('people.show');
    Route::get('/search', [\App\Http\Controller\PersonController::class, 'search'])->name('people.search');
});

Route::group('/planets', function () {
    Route::get('/', [\App\Http\Controller\PlanetController::class, 'index'])->name('planets.index');
    Route::get('/{id}', [\App\Http\Controller\PlanetController::class, 'show'])->name('planets.show');
    Route::get('/search', [\App\Http\Controller\PlanetController::class, 'search'])->name('planets.search');
});

Route::group('/species', function () {
    Route::get('/', [\App\Http\Controller\SpecieController::class, 'index'])->name('species.index');
    Route::get('/{id}', [\App\Http\Controller\SpecieController::class, 'show'])->name('species.show');
    Route::get('/search', [\App\Http\Controller\SpecieController::class, 'search'])->name('species.search');
});

Route::group('/starships', function () {
    Route::get('/', [\App\Http\Controller\StarshipController::class, 'index'])->name('starships.index');
    Route::get('/{id}', [\App\Http\Controller\StarshipController::class, 'show'])->name('starships.show');
    Route::get('/search', [\App\Http\Controller\StarshipController::class, 'search'])->name('starships.search');
});

Route::group('/vehicles', function () {
    Route::get('/', [\App\Http\Controller\VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/{id}', [\App\Http\Controller\VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('/search', [\App\Http\Controller\VehicleController::class, 'search'])->name('vehicles.search');
});
