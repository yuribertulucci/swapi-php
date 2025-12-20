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
        $this->viewPath = self::getViewPath($view);

        if (file_exists($this->viewPath)) {
            $this->content = file_get_contents($this->viewPath);
        }
    }

    private function replacePlaceholders(): void
    {
        preg_match('/@extends\s*\(\s*[\'"](.+)[\'"]\s*\)/', $this->content, $matches);
        if (isset($matches[1])) {
            $parentView = $matches[1];
            if (self::exists($parentView)) {
                $childContent = preg_replace('/@extends\s*\(\s*[\'"](.+)[\'"]\s*\)/', '', $this->content);
                $parentContent = file_get_contents(self::getViewPath($parentView));
                $this->content = str_replace(['{!! $slot !!}', '{{ $slot }}'], $childContent, $parentContent);
            }
        }

        $content = preg_replace('/{{\s*(.[^}}]+)\s*}}/', '<?php echo encode($1); ?>', $this->content);

        $content = preg_replace('/@if\s*\((.+)\)/', '<?php if ($1): ?>', $content);
        $content = preg_replace('/@elseif\s*\((.+)\)/', '<?php elseif ($1): ?>', $content);
        $content = preg_replace('/@else/', '<?php else: ?>', $content);
        $content = preg_replace('/@endif/', '<?php endif; ?>', $content);

        $content = preg_replace('/@include\s*\(\s*[\'"](.+)[\'"]\s*\)/', '<?php include app_path("resources/views/" . str_replace(".", "/", "$1") . ".php"); ?>', $content);

        $this->content = $content;
    }

    public static function exists(string $view): bool
    {
        $viewPath = app_path('resources/views/' . str_replace('.', '/', $view) . '.php');
        return file_exists($viewPath);
    }

    public static function getViewPath(string $view): string
    {
        return app_path('resources/views/' . str_replace('.', '/', $view) . '.php');
    }
}