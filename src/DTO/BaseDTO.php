<?php

namespace App\DTO;

abstract class BaseDTO
{
    protected array $hiddenFields = [];
    protected ?string $id;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function toArray(): array
    {
        $data = obj2array($this);

        foreach ([...$this->hiddenFields, 'hiddenFields'] as $field) {
            unset($data[$field]);
        }

        return $this->replaceSwApiUrls($data);
    }

    protected function replaceSwApiUrls(array $data): array
    {
        $url = env('SWAPI_URL', 'https://swapi.py4e.com/api');
        array_walk_recursive($data, function (&$value, $key) use ($url) {
            if ($key === 'url') {
                $value = str_replace($url, '/api/', $value);
            }
            if (is_string($value) && str_contains($value, $url)) {
                $value = str_replace($url, '/api/', $value);
            }
            if ($key === 'next' || $key === 'previous' && $value !== null) {
                $value = str_replace('&format=json', '', $value);
            }
        });

        return $data;
    }

    protected function extractIdFromUrl(string $url): ?int
    {
        if (empty($url)) {
            return null;
        }
        $parts = explode('/', trim($url, '/'));
        return is_numeric(end($parts)) ? end($parts) : null;
    }
}