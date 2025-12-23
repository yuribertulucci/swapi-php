<?php

namespace App\Service;

use App\Client\HttpClient;
use App\DTO\ApiCollectionResponseDTO;
use App\DTO\BaseDTO;
use App\DTO\FilmDTO;
use App\DTO\PersonDTO;
use App\DTO\PlanetDTO;
use App\DTO\SpecieDTO;
use App\DTO\StarshipDTO;
use App\DTO\VehicleDTO;
use Exception;

class StarWarsApiService
{
    private HttpClient $client;

    function __construct()
    {
        $this->client = new HttpClient(env('SWAPI_URL', 'https://swapi.py4e.com/api/'), 'json');
    }

    /**
     * @throws Exception
     */
    public function getPeople($page = null): BaseDTO
    {
        $params = [];
        if (!empty($page)) {
            $params = ['page' => $page];
        }

        $data = $this->client->get('people/', $params);
        return new ApiCollectionResponseDTO($data, PersonDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getPerson(int $id): BaseDTO
    {
        $data = $this->client->get("people/{$id}/");
        return new PersonDTO($data);
    }

    /**
     * @throws Exception
     */
    public function searchPeople(string $query, $page = null): BaseDTO
    {
        $params = ['search' => $query];
        if (!empty($page)) {
            $params['page'] = $page;
        }

        $data = $this->client->get('people/', $params);
        return new ApiCollectionResponseDTO($data, PersonDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getFilms($page = null): BaseDTO
    {
        $params = [];
        if (!empty($page)) {
            $params = ['page' => $page];
        }

        $data = $this->client->get('films/', $params);
        return new ApiCollectionResponseDTO($data, FilmDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getFilm(int $id): BaseDTO
    {
        $data = $this->client->get("films/{$id}/");
        return new FilmDTO($data);
    }

    /**
     * @throws Exception
     */
    public function searchFilms(string $query, $page = null): BaseDTO
    {
        $params = ['search' => $query];
        if (!empty($page)) {
            $params['page'] = $page;
        }

        $data = $this->client->get('films/', $params);
        return new ApiCollectionResponseDTO($data, FilmDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getStarships($page = null): BaseDTO
    {
        $params = [];
        if (!empty($page)) {
            $params = ['page' => $page];
        }

        $data = $this->client->get('starships/', $params);
        return new ApiCollectionResponseDTO($data, StarshipDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getStarship(int $id): BaseDTO
    {
        $data = $this->client->get("starships/{$id}/");
        return new StarshipDTO($data);
    }

    /**
     * @throws Exception
     */
    public function searchStarships(string $query, $page = null): BaseDTO
    {
        $params = ['search' => $query];
        if (!empty($page)) {
            $params['page'] = $page;
        }

        $data = $this->client->get('starships/', $params);
        return new ApiCollectionResponseDTO($data, StarshipDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getPlanets($page = null): BaseDTO
    {
        $params = [];
        if (!empty($page)) {
            $params = ['page' => $page];
        }

        $data = $this->client->get('planets/', $params);
        return new ApiCollectionResponseDTO($data, PlanetDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getPlanet(int $id): BaseDTO
    {
        $data = $this->client->get("planets/{$id}/");
        return new PlanetDTO($data);
    }

    /**
     * @throws Exception
     */
    public function searchPlanets(string $query, $page = null): BaseDTO
    {
        $params = ['search' => $query];
        if (!empty($page)) {
            $params['page'] = $page;
        }

        $data = $this->client->get('planets/', $params);
        return new ApiCollectionResponseDTO($data, PlanetDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getSpecies($page = null): BaseDTO
    {
        $params = [];
        if (!empty($page)) {
            $params = ['page' => $page];
        }

        $data = $this->client->get('species/', $params);
        return new ApiCollectionResponseDTO($data, SpecieDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getSpecie(int $id): BaseDTO
    {
        $data = $this->client->get("species/{$id}/");
        return new SpecieDTO($data);
    }

    /**
     * @throws Exception
     */
    public function searchSpecies(string $query, $page = null): BaseDTO
    {
        $params = ['search' => $query];
        if (!empty($page)) {
            $params['page'] = $page;
        }

        $data = $this->client->get('species/', $params);
        return new ApiCollectionResponseDTO($data, SpecieDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getVehicles($page = null): BaseDTO
    {
        $params = [];
        if (!empty($page)) {
            $params = ['page' => $page];
        }

        $data = $this->client->get('vehicles/', $params);
        return new ApiCollectionResponseDTO($data, VehicleDTO::class);
    }

    /**
     * @throws Exception
     */
    public function getVehicle(int $id): BaseDTO
    {
        $data = $this->client->get("vehicles/{$id}/");
        return new VehicleDTO($data);
    }

    /**
     * @throws Exception
     */
    public function searchVehicles(string $query, $page = null): BaseDTO
    {
        $params = ['search' => $query];
        if (!empty($page)) {
            $params['page'] = $page;
        }

        $data = $this->client->get('vehicles/', $params);
        return new ApiCollectionResponseDTO($data, VehicleDTO::class);
    }
}