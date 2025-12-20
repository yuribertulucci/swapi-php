<?php

namespace App\Http\Controller;

use App\Http\Response;

class FilmController
{
    public function index(): Response
    {
        return view('films.index');
    }

    public function show($id): Response
    {
        return view('films.show', ['id' => $id]);
    }

    public function search($query)
    {
        // Logic to search for films
    }
}