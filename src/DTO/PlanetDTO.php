<?php

namespace App\DTO;

class PlanetDTO extends BaseDTO
{
    private string $name;
    private string $diameter;
    private string $rotationPeriod;
    private string $orbitalPeriod;
    private string $gravity;
    private string $population;
    private string $climate;
    private string $terrain;
    private string $surfaceWater;
    private array $residents;
    private array $films;
    private string $url;
    private string $created;
    private string $edited;
    private string $pageUrl;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->diameter = $data['diameter'] ?? '';
        $this->rotationPeriod = $data['rotation_period'] ?? '';
        $this->orbitalPeriod = $data['orbital_period'] ?? '';
        $this->gravity = $data['gravity'] ?? '';
        $this->population = $data['population'] ?? '';
        $this->climate = $data['climate'] ?? '';
        $this->terrain = $data['terrain'] ?? '';
        $this->surfaceWater = $data['surface_water'] ?? '';
        $this->residents = $data['residents'] ?? [];
        $this->films = $data['films'] ?? [];
        $this->url = $data['url'] ?? '';
        $this->created = $data['created'] ?? '';
        $this->edited = $data['edited'] ?? '';

        $this->id = $this->extractIdFromUrl($this->url);
        $this->pageUrl = route('planets.show', ['id' => $this->id]);
    }

    public function toArray(): array
    {
        return $this->replaceSwApiUrls([
            'name' => $this->getName(),
            'diameter' => $this->getDiameter(),
            'rotation_period' => $this->getRotationPeriod(),
            'orbital_period' => $this->getOrbitalPeriod(),
            'gravity' => $this->getGravity(),
            'population' => $this->getPopulation(),
            'climate' => $this->getClimate(),
            'terrain' => $this->getTerrain(),
            'surface_water' => $this->getSurfaceWater(),
            'residents' => $this->getResidents(),
            'films' => $this->getFilms(),
            'url' => $this->getUrl(),
            'created' => $this->getCreated(),
            'edited' => $this->getEdited(),
            'id' => $this->getId(),
            'page_url' => $this->getPageUrl(),
        ]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDiameter(): string
    {
        return $this->diameter;
    }

    public function getRotationPeriod(): string
    {
        return $this->rotationPeriod;
    }

    public function getOrbitalPeriod(): string
    {
        return $this->orbitalPeriod;
    }

    public function getGravity(): string
    {
        return $this->gravity;
    }

    public function getPopulation(): string
    {
        return $this->population;
    }

    public function getClimate(): string
    {
        return $this->climate;
    }

    public function getTerrain(): string
    {
        return $this->terrain;
    }

    public function getSurfaceWater(): string
    {
        return $this->surfaceWater;
    }

    public function getResidents(): array
    {
        return $this->residents;
    }

    public function getFilms(): array
    {
        return $this->films;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCreated(): string
    {
        return $this->created;
    }

    public function getEdited(): string
    {
        return $this->edited;
    }

    public function getPageUrl(): string
    {
        return $this->pageUrl;
    }
}