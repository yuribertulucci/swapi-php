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
    private array $planets;
    private string $url;
    private string $created;
    private string $edited;
    private string $pageUrl;
    private string $age;

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
        $this->planets = $data['planets'] ?? [];
        $this->url = $data['url'] ?? '';
        $this->created = $data['created'] ?? '';
        $this->edited = $data['edited'] ?? '';

        $this->id = $this->extractIdFromUrl($this->url);
        $this->pageUrl = route('films.show', ['id' => $this->id]);

        $this->age = $this->calculateAge($this->releaseDate) ?? 'Unknown';
    }

    public function toArray(): array
    {
        return $this->replaceSwApiUrls([
            'title' => $this->getTitle(),
            'episode_id' => $this->getEpisodeId(),
            'opening_crawl' => $this->getOpeningCrawl(),
            'director' => $this->getDirector(),
            'producer' => $this->getProducer(),
            'release_date' => $this->getReleaseDate(),
            'species' => $this->getSpecies(),
            'starships' => $this->getStarships(),
            'vehicles' => $this->getVehicles(),
            'characters' => $this->getCharacters(),
            'planets' => $this->getPlanets(),
            'url' => $this->getUrl(),
            'created' => $this->getCreated(),
            'edited' => $this->getEdited(),
            'id' => $this->getId(),
            'page_url' => $this->getPageUrl(),
            'age' => $this->getAge(),
        ]);
    }

    private function calculateAge(string $releaseDate): ?string
    {
        $releaseYear = date_create($releaseDate);
        $currentYear = date_create(date('Y-m-d'));

        $dateInterval = date_diff($releaseYear, $currentYear);
        if (! $dateInterval) {
            return null;
        }

        $stringParts = [];
        if ($dateInterval->y > 0) {
            $stringParts[] = $dateInterval->y . ' year' . ($dateInterval->y > 1 ? 's' : '');
        }
        if ($dateInterval->m > 0) {
            $stringParts[] = $dateInterval->m . ' month' . ($dateInterval->m > 1 ? 's' : '');
        }
        if ($dateInterval->d > 0) {
            $stringParts[] = $dateInterval->d . ' day' . ($dateInterval->d > 1 ? 's' : '');
        }

        if (count($stringParts) > 1) {
            return implode(', ', array_slice($stringParts, 0, -1)) . ' and ' . end($stringParts);
        } else {
            return end($stringParts);
        }
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

    public function getPageUrl(): string
    {
        return $this->pageUrl;
    }

    public function getAge(): string
    {
        return $this->age;
    }

    public function getPlanets()
    {
        return $this->planets;
    }

}