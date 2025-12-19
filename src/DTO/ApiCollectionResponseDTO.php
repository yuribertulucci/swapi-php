<?php

namespace App\DTO;

class ApiCollectionResponseDTO extends BaseDTO
{
    private int $count;
    private int $pages;
    private ?string $next;
    private ?string $previous;
    private array $results;
    private string $collectionItemDTO;

    public function __construct(array $data, ?string $collectionItemDTO = null)
    {
        $this->count = $data['count'] ?? '';
        $this->next = $data['next'] ?? '';
        $this->previous = $data['previous'] ?? '';
        $this->results = $data['results'] ?? [];
        $this->pages = (int) ceil((int) $data['count'] / 10 ?? 0);

        $this->collectionItemDTO = $collectionItemDTO;
        $this->transformResults();
    }

    public function toArray(): array
    {
        return [
            'count' => $this->getCount(),
            'pages' => $this->getPages(),
            'next' => $this->getNext(),
            'previous' => $this->getPrevious(),
            'results' => array_map(function ($item) {
                if ($item instanceof BaseDTO) {
                    return $item->toArray();
                }
                return $item;
            }, $this->getResults()),
        ];
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

    private function transformResults()
    {
        if ($this->collectionItemDTO && class_exists($this->collectionItemDTO)) {
            $dtoClass = $this->collectionItemDTO;
        } else {
            return;
        }

        $originalResults = $this->results;
        $this->results = [];
        foreach ($originalResults as $index => $result) {
            $this->results[$index] = new $dtoClass($result);
        }
    }
}