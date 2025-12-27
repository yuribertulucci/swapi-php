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

    /**
     * @param string $method
     * @param string $pattern
     * @param array<string, string>|\Closure $action
     */
    public function __construct(string $method, string $pattern, $action)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->action = $action;
    }

    /**
     * Defines a group of routes with shared configurations.
     *
     * @param string|array<string, mixed> $configs
     * @param \Closure $routes
     *
     * @return void
     */
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

    /**
     * Creates a GET route.
     *
     * @param string $pattern
     * @param array<string, string>|\Closure $action
     *
     * @return Route
     */
    public static function get(string $pattern, $action): Route
    {
        return Router::addRouteStatic('GET', $pattern, $action);
    }

    /**
     * Creates a POST route.
     *
     * @param string $pattern
     * @param array<string, string>|\Closure $action
     *
     * @return Route
     */
    public static function post(string $pattern, $action): Route
    {
        return Router::addRouteStatic('POST', $pattern, $action);
    }

    /**
     * Sets the name of the route.
     * To be used in a chain after route creation.
     *
     * @param string $name
     *
     * @return self
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Converts the route pattern to a regular expression and stores it inside the route's patternRegex property.
     *
     * @return string
     */
    public function convertPatternToRegex(): string
    {
        $regex = preg_replace('/{[^\/]+}/', '([^/]+)', $this->pattern);
        $regex = str_replace('/', '\/', $regex);
        $this->patternRegex = '/^' . $regex . '?$/';

        return $this->patternRegex;
    }

    /**
     * Extracts parameters from the request URI based on the route pattern and
     * stores them inside the route parameters property.
     *
     * @return void
     */
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

    /**
     * Returns an associative array with route details.
     *
     * @return array<string, mixed>
     */
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

    /**
     * Adds middlewares to the route.
     *
     * @param string|array<string> $middlewares
     *
     * @return self
     */
    public function withMiddleware($middlewares): self
    {
        if (!is_array($middlewares)) {
            $middlewares = [$middlewares];
        }

        $this->middlewares = array_merge($this->middlewares, $middlewares);

        return $this;
    }
}