<?php

namespace App\Http\Controller\Api;

use App\Http\Response;
use App\Service\StarWarsApiService;

class PlanetController
{
    private StarWarsApiService $starWarsApiService;

    function __construct()
    {
        $this->starWarsApiService = new StarWarsApiService();
    }


    public function index(): Response
    {
        try {
            $planets = $this->starWarsApiService->getPlanets(request()->getQuery('page'));
            return response()->json($planets);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function show($id): Response
    {
        try {
            $planet = $this->starWarsApiService->getPlanet($id);
            return response()->json($planet);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function search(): Response
    {
        try {
            $planets = $this->starWarsApiService->searchPlanets(
                request()->getQuery('query'),
                request()->getQuery('page')
            );
            return response()->json($planets);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }
}