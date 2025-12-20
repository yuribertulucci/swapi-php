<?php

namespace App\Http\Controller;

use App\Http\Response;

class PlanetController
{
    public function index(): Response
    {
        return view('planets.index');
    }

    public function show($id): Response
    {
        return view('planets.show', ['id' => $id]);
    }

    public function search($query)
    {
        // Logic to search for planets
    }
}