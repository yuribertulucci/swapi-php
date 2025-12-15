<?php

namespace App\Core;

use App\Routing\Route;
use App\Routing\Router;
use App\Traits\SingletonInstance;

class Application
{
    use SingletonInstance;

    private string $basePath;
    private array $routes = [];
    private array $singletons = [];
    private array $config = [];

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
                    Route::group(['prefix' => $this->config['routes']['prefix']['api'] ?? 'api'], function() use ($routesFilePath) {
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

    public function getBasePath(): string
    {
        return $this->basePath;
    }
}