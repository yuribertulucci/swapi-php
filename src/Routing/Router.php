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

    public function loadRoutes(array $routes): void
    {
        $this->routes = array_merge($this->routes, $routes);
    }

    public function addRoute(string $method, string $pattern, $action): Route
    {
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

        $searchRoutes = $this->routes[$method] ?? [];

        if (isset($searchRoutes[$uri])) {
            $this->route = $uri;
            return $this->processRoute($searchRoutes[$uri]);
        }

        foreach ($searchRoutes as $pattern => $route) {
            $regex = $route->convertToRegex($pattern);

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

        if (is_string($routeAction)) {
            $controllerAction = explode('@', $routeAction);
            $controllerName = $controllerAction[0];
            $actionName = $controllerAction[1];

            $controller = new $controllerName();
            return $controller->$actionName(...array_values($routeParams));
        }

        if (is_array($routeAction)) {
            $controllerName = $routeAction[0];
            $actionName = $routeAction[1];

            $controller = new $controllerName();
            return $controller->$actionName(...array_values($routeParams));
        }

        if ($routeAction instanceof \Closure) {
            return $routeAction(...array_values($routeParams));
        }

        return null;
    }
}