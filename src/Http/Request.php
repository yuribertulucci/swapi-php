<?php

namespace App\Http;

use App\Traits\SingletonInstance;

class Request
{
    use SingletonInstance;

    private string $method;
    private string $uri;
    private array $query;
    private ?array $routeParams = null;
    private array $body;

    private function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->query = $_GET;
        $this->body = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        if ($this->uri[-1] !== '/') {
            $this->uri .= '/';
        }
        if ($this->uri[0] !== '/') {
            $this->uri = '/' . $this->uri;
        }

        return $this->uri;
    }

    public function getQuery(string $key, $default = null)
    {
        return $this->query[$key] ?? $default;
    }

    public function getQueryParams(): array
    {
        return $this->query;
    }

    public function getRouteParams(): array
    {
        return $this->routeParams ?? [];
    }

    public function setRouteParams(string $key, $value): void
    {
        $this->routeParams[$key] = $value;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}