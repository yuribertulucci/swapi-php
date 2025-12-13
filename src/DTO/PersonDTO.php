<?php

namespace App\DTO;

class PersonDTO extends BaseDTO
{
    private string $name;
    private string $birthYear;
    private string $gender;
    private string $hairColor;
    private int $height;
    private int $mass;
    private string $skinColor;
    private string $homeworld;
    private array $films;
    private array $species;
    private array $starships;
    private array $vehicles;
    private string $url;
    private string $created;
    private string $edited;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->birthYear = $data['birth_year'] ?? '';
        $this->gender = $data['gender'] ?? '';
        $this->hairColor = $data['hair_color'] ?? '';
        $this->height = $data['height'] ?? '';
        $this->mass = $data['mass'] ?? '';
        $this->skinColor = $data['skin_color'] ?? '';
        $this->homeworld = $data['homeworld'] ?? '';
        $this->films = $data['films'] ?? [];
        $this->species = $data['species'] ?? [];
        $this->starships = $data['starships'] ?? [];
        $this->vehicles = $data['vehicles'] ?? [];
        $this->url = $data['url'] ?? '';
        $this->created = $data['created'] ?? '';
        $this->edited = $data['edited'] ?? '';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthYear(): string
    {
        return $this->birthYear;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getHairColor(): string
    {
        return $this->hairColor;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getMass(): int
    {
        return $this->mass;
    }

    public function getSkinColor(): string
    {
        return $this->skinColor;
    }

    public function getHomeworld(): string
    {
        return $this->homeworld;
    }

    public function getFilms(): array
    {
        return $this->films;
    }

    public function getSpecies(): array
    {
        return $this->species;
    }

    public function getStarships(): array
    {
        return $this->starships;
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
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

}