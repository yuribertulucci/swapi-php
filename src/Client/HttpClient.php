<?php

namespace App\Client;

class HttpClient
{
    private string $responseFormat;
    private string $baseUrl;

    public function __construct(string $baseUrl = '', string $responseFormat = 'json')
    {
        $this->baseUrl = $baseUrl;
        $this->responseFormat = $responseFormat;
    }

    public function get(string $url, array $params = []): array
    {
        $ch = curl_init();
        if ($this->responseFormat === 'json') {
            $params = array_merge($params, ['format' => 'json']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
            ]);
        }
        $queryString = http_build_query($params);
        $fullUrl = $this->baseUrl . $url . ($queryString ? '?' . $queryString : '');
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $errorMessage = curl_error($ch);
            curl_close($ch);
            throw new \Exception('Request Error: ' . $errorMessage);
        }

        curl_close($ch);

        if ($httpCode >= 400) {
            throw new \Exception('HTTP Error: ' . $httpCode);
        }

        return json_decode($response, true);
    }
}