<?php

namespace App\Http;

class View
{
    private string $viewsPath;
    public string $viewPath = '';
    private string $content = '';

    function __construct()
    {
        $this->viewsPath = app_path('resources/views/');
    }

    public function render(string $view, array $data = []): string
    {
        $this->loadViewContent($view);
        $this->replacePlaceholders();

        if (file_exists($this->viewPath)) {
            extract($data, EXTR_SKIP);
            ob_start();
            eval('?>' . $this->content);
            return ob_get_clean();
        } else {
            throw new \Exception("View file not found: {$this->viewPath}");
        }
    }

    public function loadViewContent(string $view): void
    {
        $this->viewPath = $this->viewsPath . str_replace('.', '/', $view) . '.php';

        if (file_exists($this->viewPath)) {
            $this->content = file_get_contents($this->viewPath);
        }
    }

    private function replacePlaceholders(): void
    {
        $content = preg_replace('/{{\s*(.+)\s*}}/', '<?php echo encode($1); ?>', $this->content);
        $this->content = $content;
    }

    public static function exists(string $view): bool
    {
        $viewPath = app_path('resources/views/' . str_replace('.', '/', $view) . '.php');
        return file_exists($viewPath);
    }
}