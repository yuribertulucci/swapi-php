<?php

namespace App\DTO;

abstract class BaseDTO
{
    protected array $hiddenFields = [];

    public function toArray(): array
    {
        $data = obj2array($this);

        foreach ([...$this->hiddenFields, 'hiddenFields'] as $field) {
            unset($data[$field]);
        }

        return $this->replaceSwApiUrls($data);
    }

    private function replaceSwApiUrls(array $data): array
    {
        array_walk_recursive($data, function (&$value, $key) {
            if ($key === 'url') {
                $value = str_replace('https://swapi.dev/api/', '/api/', $value);
            }
            if (is_string($value) && str_contains($value, 'swapi.dev')) {
                $value = str_replace('https://swapi.dev/api/', '/api/', $value);
            }
            if ($key === 'next' || $key === 'previous' && $value !== null) {
                $value = str_replace('&format=json', '', $value);
            }
        });

        return $data;
    }
}