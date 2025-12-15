<?php

namespace App\Routing;

use App\Http\Request;
use App\Http\Response;
use App\Traits\SingletonInstance;

class Router
{
    use SingletonInstance;

    private array $routes;
    private string $route = '';
    private string $routePrefix = '';

    public static function routePrefix($routePrefix): Router
    {
        $instance = self::instance();
        $instance->routePrefix .= '/' . trim($routePrefix, '/');

        return $instance;
    }

    public function loadRoutes(array $routes): void
    {
        $this->routes = array_merge($this->routes, $routes);
    }

    public function addRoute(string $method, string $pattern, $action): Route
    {
        $pattern = $this->routePrefix . '/' . trim($pattern, '/') . '/';

        return $this->routes[$method][$pattern] = new Route($method, $pattern, $action);
    }

    public static function addRouteStatic(string $method, string $pattern, $action): Route
    {
        return self::instance()->addRoute($method, $pattern, $action);
    }

    public function handleRequest(Request $request): ?Response
    {
        $uri = $request->getUri();
        $method = $request->getMethod();

        /* @var array<string, Route> $searchRoutes */
        $searchRoutes = $this->routes[$method] ?? [];

        if (isset($searchRoutes[$uri])) {
            $this->route = $uri;
            return $this->processRoute($searchRoutes[$uri]);
        }

        foreach ($searchRoutes as $pattern => $route) {
            $regex = $route->convertPatternToRegex();

            if (preg_match($regex, $uri)) {
                $this->route = $pattern;
                $route->extractParams($pattern, $uri);
                return $this->processRoute($route);
            }
        }

        return response()->notFound();
    }

    public function processRoute(Route $route): ?Response
    {
        $routeDetails = $route->getDetails();
        $routeAction = $routeDetails['action'];
        $routeParams = $routeDetails['parameters'] ?? [];
        $routeActionParams = array_values($routeParams);

        if (is_string($routeAction)) {
            $controllerAction = explode('@', $routeAction);
            $controllerName = $controllerAction[0];
            $actionName = $controllerAction[1];

            $controller = new $controllerName();
            return $controller->$actionName(...$routeActionParams);
        }

        if (is_array($routeAction)) {
            $controllerName = $routeAction[0];
            $actionName = $routeAction[1];

            $controller = new $controllerName();
            return $controller->$actionName(...$routeActionParams);
        }

        if ($routeAction instanceof \Closure) {
            return $routeAction(...$routeActionParams);
        }

        return null;
    }
}