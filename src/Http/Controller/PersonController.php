<?php

namespace App\Http\Controller;

use App\Http\Request;
use App\Http\Response;
use App\Service\StarWarsApiService;

class PersonController
{
    private StarWarsApiService $starWarsApiService;

    function __construct()
    {
        $this->starWarsApiService = new StarWarsApiService();
    }


    public function index(Request $request, Response $response): Response
    {
        try {
            $people = $this->starWarsApiService->getPeople();
            return $response->json($people);
        } catch (\Exception $e) {
            return $response->error($e->getMessage());
        }
    }

    public function show($id)
    {
        // Logic to show a specific person
    }

    public function search($query)
    {
        // Logic to search for people
    }
}