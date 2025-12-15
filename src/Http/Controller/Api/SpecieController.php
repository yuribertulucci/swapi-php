<?php

namespace App\Http\Controller\Api;

use App\Http\Response;
use App\Service\StarWarsApiService;

class SpecieController
{
    private StarWarsApiService $starWarsApiService;

    function __construct()
    {
        $this->starWarsApiService = new StarWarsApiService();
    }


    public function index(): Response
    {
        try {
            $films = $this->starWarsApiService->getSpecies(request()->getQuery('page'));
            return response()->json($films);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function show($id): Response
    {
        try {
            $film = $this->starWarsApiService->getSpecie($id);
            return response()->json($film);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function search(): Response
    {
        try {
            $films = $this->starWarsApiService->searchSpecies(
                request()->getQuery('query'),
                request()->getQuery('page')
            );
            return response()->json($films);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }
}