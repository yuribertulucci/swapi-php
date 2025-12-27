<?php

namespace App\Http\Controller;

use App\Http\Response;

class VehicleController
{
    public function index(): Response
    {
        return view('vehicles.index');
    }

    public function show($id): Response
    {
        return view('vehicles.show', ['id' => $id]);
    }

    public function search(): Response
    {
        return view('vehicles.search', ['query' => request()->getQuery('query', '')]);
    }
}