<?php

namespace App\DTO;

class VehicleDTO extends BaseDTO
{
    private string $name;
    private string $model;
    private string $vehicleClass;
    private string $manufacturer;
    private string $length;
    private string $costInCredits;
    private string $crew;
    private string $passengers;
    private string $maxAtmospheringSpeed;
    private string $cargoCapacity;
    private string $consumables;
    private array $films;
    private array $pilots;
    private string $url;
    private string $created;
    private string $edited;
    private string $pageUrl;

    function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->model = $data['model'] ?? '';
        $this->vehicleClass = $data['vehicle_class'] ?? '';
        $this->manufacturer = $data['manufacturer'] ?? '';
        $this->length = $data['length'] ?? '';
        $this->costInCredits = $data['cost_in_credits'] ?? '';
        $this->crew = $data['crew'] ?? '';
        $this->passengers = $data['passengers'] ?? '';
        $this->maxAtmospheringSpeed = $data['max_atmosphering_speed'] ?? '';
        $this->cargoCapacity = $data['cargo_capacity'] ?? '';
        $this->consumables = $data['consumables'] ?? '';
        $this->films = $data['films'] ?? [];
        $this->pilots = $data['pilots'] ?? [];
        $this->url = $data['url'] ?? '';
        $this->created = $data['created'] ?? '';
        $this->edited = $data['edited'] ?? '';

        $this->id = $this->extractIdFromUrl($this->url);
        $this->pageUrl = route('vehicles.show', ['id' => $this->id]);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'model' => $this->getModel(),
            'vehicle_class' => $this->getVehicleClass(),
            'manufacturer' => $this->getManufacturer(),
            'length' => $this->getLength(),
            'cost_in_credits' => $this->getCostInCredits(),
            'crew' => $this->getCrew(),
            'passengers' => $this->getPassengers(),
            'max_atmosphering_speed' => $this->getMaxAtmospheringSpeed(),
            'cargo_capacity' => $this->getCargoCapacity(),
            'consumables' => $this->getConsumables(),
            'films' => $this->getFilms(),
            'pilots' => $this->getPilots(),
            'url' => $this->getUrl(),
            'created' => $this->getCreated(),
            'edited' => $this->getEdited(),
            'id' => $this->getId(),
            'page_url' => $this->getPageUrl(),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getVehicleClass(): string
    {
        return $this->vehicleClass;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getLength(): string
    {
        return $this->length;
    }

    public function getCostInCredits(): string
    {
        return $this->costInCredits;
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

    public function getPageUrl(): string
    {
        return $this->pageUrl;
    }
}