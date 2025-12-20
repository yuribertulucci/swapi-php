<?php

namespace App\Http\Controller;

use App\Http\Response;

class StarshipController
{
    public function index(): Response
    {
        return view('starships.index');
    }

    public function show($id): Response
    {
        return view('starships.show', ['id' => $id]);
    }

    public function search($query)
    {
        // Logic to search for starships
    }
}