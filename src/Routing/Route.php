<?php

namespace App\Routing;

class Route
{
    private string $method;
    private string $pattern;
    private string $patternRegex;
    private $action;
    private ?string $name = null;
    private ?array $parameters = null;
    private array $middlewares = [];

    public function __construct(string $method, string $pattern, $action)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->action = $action;
    }

    public static function group($configs, \Closure $routes): void
    {
        if (is_string($configs) && ! empty($configs)) {
            $configs = ['prefix' => $configs];
        }

        if (isset($configs['prefix'])) {
            Router::routePrefix($configs['prefix']);
            $removePrefix = true;
        }

        if (isset($configs['middleware'])) {
            Router::routeMiddleware($configs['middleware']);
            $removeMiddleware = true;
        }

        $routes();

        if (isset($removePrefix)) {
            Router::removeLastRoutePrefix();
        }
        if (isset($removeMiddleware)) {
            Router::removeLastMiddleware();
        }
    }

    public static function get(string $pattern, $action): Route
    {
        return Router::addRouteStatic('GET', $pattern, $action);
    }

    public static function post(string $pattern, $action): Route
    {
        return Router::addRouteStatic('POST', $pattern, $action);
    }

    public function name(string $name): Route
    {
        $this->name = $name;
        return $this;
    }

    public function convertPatternToRegex(): string
    {
        $regex = preg_replace('/{[^\/]+}/', '([^/]+)', $this->pattern);
        $regex = str_replace('/', '\/', $regex);
        return '/^' . $regex . '?$/';
    }

    public function extractParams(): void
    {
        preg_match_all('/{([^\/]+)}/', $this->pattern, $paramNames);

        $regex = $this->convertPatternToRegex();
        preg_match($regex, request()->getUri(), $paramValues);

        array_shift($paramValues); // Remove match completo

        foreach ($paramNames[1] as $index => $name) {
            $this->parameters[$name] = $paramValues[$index] ?? null;
        }
    }

    public function getDetails(): array
    {
        return [
            'method' => $this->method,
            'pattern' => $this->pattern,
            'action' => $this->action,
            'name' => $this->name,
            'parameters' => $this->parameters,
            'middlewares' => $this->middlewares,
        ];
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function withMiddleware($middlewares): self
    {
        if (!is_array($middlewares)) {
            $middlewares = [$middlewares];
        }

        $this->middlewares = array_merge($this->middlewares, $middlewares);

        return $this;
    }
}