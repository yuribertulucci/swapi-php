<?php

namespace App\Http\Controller\Api;

use App\Http\Response;
use App\Service\StarWarsApiService;

class VehicleController
{
    private StarWarsApiService $starWarsApiService;

    function __construct()
    {
        $this->starWarsApiService = new StarWarsApiService();
    }


    public function index(): Response
    {
        try {
            $films = $this->starWarsApiService->getFilms(request()->getQuery('page'));
            return response()->json($films);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function show($id): Response
    {
        try {
            $film = $this->starWarsApiService->getFilm($id);
            return response()->json($film);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function search(): Response
    {
        try {
            $films = $this->starWarsApiService->searchFilms(
                request()->getQuery('query'),
                request()->getQuery('page')
            );
            return response()->json($films);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }
}