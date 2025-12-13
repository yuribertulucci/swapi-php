<?php

namespace App\Http\Controller\Api;

use App\Http\Response;
use App\Service\StarWarsApiService;

class PersonController
{
    private StarWarsApiService $starWarsApiService;

    function __construct()
    {
        $this->starWarsApiService = new StarWarsApiService();
    }


    public function index(): Response
    {
        try {
            $people = $this->starWarsApiService->getPeople(request()->getQuery('page'));
            return response()->json($people);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function show($id): Response
    {
        try {
            $person = $this->starWarsApiService->getPerson($id);
            return response()->json($person);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function search(): Response
    {
        try {
            $people = $this->starWarsApiService->searchPeople(
                request()->getQuery('query'),
                request()->getQuery('page')
            );
            return response()->json($people);
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }
}