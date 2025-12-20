<?php

namespace App\Core;

use App\Routing\Router;
use App\Traits\SingletonInstance;
use Dotenv\Dotenv;

class Application
{
    use SingletonInstance;

    private string $basePath;
    private array $routes = [];
    private array $singletons = [];
    private array $config = [];
    private array $env = [];

    private function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public static function configure(string $basePath): Application
    {
        return self::instance($basePath);
    }

    public function withRouting(string $webPath, string $apiPath): Application
    {
        $this->routes['web'] = realpath($webPath);
        $this->routes['api'] = realpath($apiPath);

        return $this;
    }

    public function withSingletons(array $singletons): Application
    {
        $this->singletons = $singletons;
        return $this;
    }

    public function run(): void
    {
        $this->bootstrap();

        // Serve static files directly if they exist
        $requestUri = parse_url(rtrim(request()->getUri(), '/'), PHP_URL_PATH);
        if (preg_match('/\.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)$/', $requestUri)) {
            $filePath = app_path('public' . $requestUri);

            if (file_exists($filePath)) {
                $mimeTypes = [
                    'css' => 'text/css',
                    'js' => 'application/javascript',
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'ico' => 'image/x-icon',
                    'svg' => 'image/svg+xml',
                ];

                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';

                header('Content-Type: ' . $mimeType);
                readfile($filePath);
                exit;
            }
        }

        $response = Router::instance()->handleRequest(request());

        ob_start();
        if ($response) {
            $response->send();
        } else {
            response()->notFound()->send();
        }
        ob_end_flush();
    }


    /*
     * Bootstrap the application by loading configurations and routes.
     */
    private function bootstrap(): void
    {
        $this->loadEnv();
        $this->loadConfig();
        $this->loadSingletons();
        $this->loadRoutes();
    }

    /*
     * Load route files from the specified paths.
     */
    private function loadRoutes(): void
    {
        foreach ($this->routes as $routeType => $routesFilePath) {
            if (file_exists($routesFilePath)) {
                if ($routeType === 'api' && isset($this->config['routes']['prefix']['api'])) {
                    Router::withGlobalPrefix($this->config['routes']['prefix']['api'], function () use ($routesFilePath) {
                        require $routesFilePath;
                    });
                    continue;
                }

                require $routesFilePath;
            }
        }
    }

    private function loadSingletons(): void
    {
        foreach ($this->singletons as $singletonClass) {
            if (class_exists($singletonClass) && method_exists($singletonClass, 'instance')) {
                $singletonClass::instance();
            }
        }
    }

    /*
     * Load configuration files from the config directory.
     */
    private function loadConfig(): void
    {
        $configPath = $this->basePath . DIRECTORY_SEPARATOR . 'config';

        if (is_dir($configPath)) {
            $configFiles = scandir($configPath);
            foreach ($configFiles as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    $configName = pathinfo($file, PATHINFO_FILENAME);
                    $this->config[$configName] = require $configPath . DIRECTORY_SEPARATOR . $file;
                }
            }
        }
    }

    private function loadEnv(): void
    {
        $this->env = Dotenv::createImmutable($this->basePath)->load();
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function getEnv(string $key, $default = null)
    {
        return $this->env[$key] ?? $default;
    }
}