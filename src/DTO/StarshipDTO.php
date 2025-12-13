<?php

namespace App\DTO;

class StarshipDTO extends BaseDTO
{
    private string $name;
    private string $model;
    private string $starshipClass;
    private string $manufacturer;
    private string $costInCredits;
    private string $length;
    private string $crew;
    private string $passengers;
    private string $maxAtmospheringSpeed;
    private string $hyperdriveRating;
    private string $MGLT;
    private string $cargoCapacity;
    private string $consumables;
    private array $films;
    private array $pilots;
    private string $url;
    private string $created;
    private string $edited;

    function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->model = $data['model'] ?? '';
        $this->starshipClass = $data['starship_class'] ?? '';
        $this->manufacturer = $data['manufacturer'] ?? '';
        $this->costInCredits = $data['cost_in_credits'] ?? '';
        $this->length = $data['length'] ?? '';
        $this->crew = $data['crew'] ?? '';
        $this->passengers = $data['passengers'] ?? '';
        $this->maxAtmospheringSpeed = $data['max_atmosphering_speed'] ?? '';
        $this->hyperdriveRating = $data['hyperdrive_rating'] ?? '';
        $this->MGLT = $data['MGLT'] ?? '';
        $this->cargoCapacity = $data['cargo_capacity'] ?? '';
        $this->consumables = $data['consumables'] ?? '';
        $this->films = $data['films'] ?? [];
        $this->pilots = $data['pilots'] ?? [];
        $this->url = $data['url'] ?? '';
        $this->created = $data['created'] ?? '';
        $this->edited = $data['edited'] ?? '';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getStarshipClass(): string
    {
        return $this->starshipClass;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getCostInCredits(): string
    {
        return $this->costInCredits;
    }

    public function getLength(): string
    {
        return $this->length;
    }

    public function getCrew(): string
    {
        return $this->crew;
    }

    public function getPassengers(): string
    {
        return $this->passengers;
    }

    public function getMaxAtmospheringSpeed(): string
    {
        return $this->maxAtmospheringSpeed;
    }

    public function getHyperdriveRating(): string
    {
        return $this->hyperdriveRating;
    }

    public function getMGLT(): string
    {
        return $this->MGLT;
    }

    public function getCargoCapacity(): string
    {
        return $this->cargoCapacity;
    }

    public function getConsumables(): string
    {
        return $this->consumables;
    }

    public function getFilms(): array
    {
        return $this->films;
    }

    public function getPilots(): array
    {
        return $this->pilots;
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