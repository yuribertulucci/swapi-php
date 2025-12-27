<?php

namespace App\Http\Controller;

use App\Http\Response;

class PersonController
{
    public function index(): Response
    {
        return view('people.index');
    }

    public function show($id): Response
    {
        return view('people.show', ['id' => $id]);
    }

    public function search(): Response
    {
        return view('people.search', ['query' => request()->getQuery('query', '')]);
    }
}