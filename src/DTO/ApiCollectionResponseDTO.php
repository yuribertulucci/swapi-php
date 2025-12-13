<?php

namespace App\DTO;

class ApiCollectionResponseDTO extends BaseDTO
{
    private int $count;
    private int $pages;
    private ?string $next;
    private ?string $previous;
    private array $results;

    public function __construct(array $data)
    {
        $this->count = $data['count'] ?? '';
        $this->next = $data['next'] ?? '';
        $this->previous = $data['previous'] ?? '';
        $this->results = $data['results'] ?? [];
        $this->pages = (int) ceil((int) $data['count'] / 10 ?? 0);
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getNext(): ?string
    {
        return $this->next;
    }

    public function getPrevious(): ?string
    {
        return $this->previous;
    }

    public function getResults(): array
    {
        return $this->results;
    }
}