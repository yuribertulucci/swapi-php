<?php

namespace App\Http;

class Response
{
    public string $route;
    public string $lastModified;
    public string $content;

    function __construct($text = null)
    {
        if (empty($text)) {
            return;
        }

        $this->send($text);
    }

    public function send(string $content, int $statusCode = 200): self
    {
        http_response_code($statusCode);
        $this->lastModified = gmdate('D, d M Y H:i:s T');
        $this->route = request()->getUri();
        $this->content = $content;
        echo $content;

        return $this;
    }

    public function json($data, int $statusCode = 200): self
    {
        header('Content-Type: application/json');
        $processedData = $this->processData($data);

        if (is_array($processedData) || is_object($processedData)) {
            $finalData = json_encode($processedData);
        } else {
            $finalData = json_encode(['error' => 'Invalid data format for JSON response', 'data' => $processedData]);
            $statusCode = 500;
        }

        return $this->send($finalData, $statusCode);
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