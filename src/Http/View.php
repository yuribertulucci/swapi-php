<?php

namespace App\Http;

class View
{
    private string $viewsPath;
    public string $viewPath = '';

    function __construct()
    {
        $this->viewsPath = app_path('resources/views/');
    }

    public function render(string $view, array $data = []): string
    {
        $this->viewPath = $viewPath = $this->viewsPath . str_replace('.', '/', $view) . '.php';

        if (file_exists($viewPath)) {
            extract($data);
            ob_start();
            include $viewPath;
            return ob_get_clean();
        } else {
            throw new \Exception("View file not found: {$viewPath}");
        }
    }

    public static function exists(string $view): bool
    {
        $viewPath = app_path('resources/views/' . str_replace('.', '/', $view) . '.php');
        return file_exists($viewPath);
    }
}