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
            $vehicles = $this->starWarsApiService->getVehicles(request()->getQuery('page'));
            return response()->json($vehicles);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function show($id): Response
    {
        try {
            $vehicle = $this->starWarsApiService->getVehicle($id);
            return response()->json($vehicle);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function search(): Response
    {
        try {
            $vehicles = $this->starWarsApiService->searchVehicles(
                request()->getQuery('query'),
                request()->getQuery('page')
            );
            return response()->json($vehicles);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }
}