<?php

namespace App\Http\Controller;

use App\Http\Response;

class SpecieController
{
    public function index(): Response
    {
        return view('species.index');
    }

    public function show($id): Response
    {
        return view('species.show', ['id' => $id]);
    }

    public function search(): Response
    {
        return view('species.search', ['query' => request()->getQuery('query', '')]);
    }
}