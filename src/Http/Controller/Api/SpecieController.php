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
            $species = $this->starWarsApiService->getSpecies(request()->getQuery('page'));
            return response()->json($species);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function show($id): Response
    {
        try {
            $specie = $this->starWarsApiService->getSpecie($id);
            return response()->json($specie);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function search(): Response
    {
        try {
            $species = $this->starWarsApiService->searchSpecies(
                request()->getQuery('query'),
                request()->getQuery('page')
            );
            return response()->json($species);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }
}