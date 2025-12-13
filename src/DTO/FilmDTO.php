<?php

namespace App\DTO;

class FilmDTO extends BaseDTO
{
    private string $title;
    private string $episodeId;
    private string $openingCrawl;
    private string $director;
    private string $producer;
    private string $releaseDate;
    private array $species;
    private array $starships;
    private array $vehicles;
    private array $characters;
    private string $url;
    private string $created;
    private string $edited;

    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? '';
        $this->episodeId = $data['episode_id'] ?? '';
        $this->openingCrawl = $data['opening_crawl'] ?? '';
        $this->director = $data['director'] ?? '';
        $this->producer = $data['producer'] ?? '';
        $this->releaseDate = $data['release_date'] ?? '';
        $this->species = $data['species'] ?? '';
        $this->starships = $data['starships'] ?? [];
        $this->vehicles = $data['vehicles'] ?? [];
        $this->characters = $data['characters'] ?? [];
        $this->url = $data['url'] ?? '';
        $this->created = $data['created'] ?? '';
        $this->edited = $data['edited'] ?? '';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getEpisodeId(): string
    {
        return $this->episodeId;
    }

    public function getOpeningCrawl(): string
    {
        return $this->openingCrawl;
    }

    public function getDirector(): string
    {
        return $this->director;
    }

    public function getProducer(): string
    {
        return $this->producer;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
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

    public function getCharacters(): array
    {
        return $this->characters;
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