<?php

namespace App\DTO;

class SpecieDTO extends BaseDTO
{
    private string $name;
    private string $classification;
    private string $averageHeight;
    private string $averageLifespan;
    private string $eyeColors;
    private string $hairColors;
    private string $skinColors;
    private string $language;
    private string $homeworld;
    private array $people;
    private array $films;
    private string $url;
    private string $created;
    private string $edited;
    private string $pageUrl;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->classification = $data['classification'] ?? '';
        $this->averageHeight = $data['average_height'] ?? '';
        $this->averageLifespan = $data['average_lifespan'] ?? '';
        $this->eyeColors = $data['eye_colors'] ?? '';
        $this->hairColors = $data['hair_colors'] ?? '';
        $this->skinColors = $data['skin_colors'] ?? '';
        $this->language = $data['language'] ?? '';
        $this->homeworld = $data['homeworld'] ?? '';
        $this->people = $data['people'] ?? [];
        $this->films = $data['films'] ?? [];
        $this->url = $data['url'] ?? '';
        $this->created = $data['created'] ?? '';
        $this->edited = $data['edited'] ?? '';

        $this->id = $this->extractIdFromUrl($this->url);
        $this->pageUrl = route('species.show', ['id' => $this->id]);
    }

    public function toArray(): array
    {
        return $this->replaceSwApiUrls([
            'name' => $this->getName(),
            'classification' => $this->getClassification(),
            'average_height' => $this->getAverageHeight(),
            'average_lifespan' => $this->getAverageLifespan(),
            'eye_colors' => $this->getEyeColors(),
            'hair_colors' => $this->getHairColors(),
            'skin_colors' => $this->getSkinColors(),
            'language' => $this->getLanguage(),
            'homeworld' => $this->getHomeworld(),
            'people' => $this->getPeople(),
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

    public function getClassification(): string
    {
        return $this->classification;
    }

    public function getAverageHeight(): string
    {
        return $this->averageHeight;
    }

    public function getAverageLifespan(): string
    {
        return $this->averageLifespan;
    }

    public function getEyeColors(): string
    {
        return $this->eyeColors;
    }

    public function getHairColors(): string
    {
        return $this->hairColors;
    }

    public function getSkinColors(): string
    {
        return $this->skinColors;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getHomeworld(): string
    {
        return $this->homeworld;
    }

    public function getPeople(): array
    {
        return $this->people;
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