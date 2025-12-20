<?php

namespace App\Http;

class Response
{
    public string $route;
    public string $lastModified;
    public string $content;
    public int $statusCode = 200;
    public array $headers = [];

    function __construct($text = null)
    {
        if (! empty($text)) {
            $this->content = $text;
        }
    }

    public function send(?string $content = null, ?int $statusCode = null): self
    {
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }
        http_response_code($statusCode ?? $this->statusCode);
        echo $content ?? $this->content;

        return $this;
    }

    public function json($data, int $statusCode = 200): self
    {
        $this->headers['Content-Type'] = 'application/json';
        $processedData = $this->processData($data);

        if (is_array($processedData) || is_object($processedData)) {
            $finalData = json_encode($processedData);
            $this->statusCode = $statusCode ?? 200;
        } else {
            $finalData = json_encode(['error' => 'Invalid data format for JSON response', 'data' => $processedData]);
            $this->statusCode = 500;
        }

        $this->lastModified = gmdate('D, d M Y H:i:s T');
        $this->content = $finalData;

        return $this;
    }

    public function view(string $view = null, array $data = []): self
    {
        if ($view) {
            $viewRenderer = new View();

            try {
                $this->content = $viewRenderer->render($view, $data);
            } catch (\Exception $e) {
                $this->content = $viewRenderer->render('default.404', $data);
                $this->statusCode = 404;
            }
        } else {
            $this->content = "No view specified.";
            $this->statusCode = 500;
        }

        $this->headers['Content-Type'] = 'text/html';
        return $this;
    }

    public function notFound(string $message = 'Not Found'): self
    {
        $this->json(['error' => $message], 404);
        return $this;
    }

    public function error(string $message, int $statusCode = 500): self
    {
        $this->json(['error' => $message], $statusCode);
        return $this;
    }

    private function processData($data)
    {
        if (is_object($data) && method_exists($data, 'toArray')) {
            return $data->toArray();
        }

        if (is_object($data)) {
            return obj2array($data);
        }

        return $data;
    }
}