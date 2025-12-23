<?php

namespace App\Routing;

use App\Http\Request;
use App\Http\Response;
use App\Traits\SingletonInstance;

class Router
{
    use SingletonInstance;

    /* @var $routes array<string, array<string, Route>> */
    private array $routes;
    private string $route = '';
    private array $routePrefixes = [];
    private string $globalPrefix = '';
    private array $middlewares = [];

    public static function routeMiddleware($middleware): Router
    {
        $instance = self::instance();

        if (is_string($middleware)) {
            $instance->middlewares[] = $middleware;
        }
        if (is_array($middleware)) {
            $instance->middlewares = array_merge($instance->middlewares, $middleware);
        }

        return $instance;
    }

    public static function removeLastMiddleware(): Router
    {
        $instance = self::instance();
        if (is_null(array_pop($instance->middlewares))) {
            $instance->middlewares = [];
        }

        return $instance;
    }

    public static function routePrefix($routePrefix): Router
    {
        $instance = self::instance();
        $instance->routePrefixes[] = trim($routePrefix, '/');

        return $instance;
    }

    public static function removeLastRoutePrefix(): Router
    {
        $instance = self::instance();
        if (is_null(array_pop($instance->routePrefixes))) {
            $instance->clearRoutePrefixes();
        }

        return $instance;
    }

    public function clearRoutePrefixes(): void
    {
        $this->routePrefixes = [];
    }

    public function loadRoutes(array $routes): void
    {
        $this->routes = array_merge($this->routes, $routes);
    }

    public function addRoute(string $method, string $pattern, $action): Route
    {
        $currentPrefix = $this->getRoutePrefix();

        if ($pattern === '/') {
            $pattern = $currentPrefix . '/';
        } else {
            $pattern = $currentPrefix . '/' . trim($pattern, '/') . '/';
        }

        $newRoute = new Route($method, $pattern, $action);

        if (! empty($this->middlewares)) {
            $newRoute->withMiddleware($this->middlewares);
        }

        return $this->routes[$method][$pattern] = $newRoute;
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
                $route->extractParams();
                return $this->processRoute($route);
            }
        }

        return response()->notFound();
    }

    public function processRoute(Route $route): ?Response
    {
        $request = Request::instance();
        $middlewares = array_merge($this->middlewares, $route->getMiddlewares());

        // Criar a cadeia de middlewares
        $next = function () use ($route) {
            $routeDetails = $route->getDetails();
            $routeAction = $routeDetails['action'];
            $routeParams = $routeDetails['parameters'] ?? [];
            $routeActionParams = array_values($routeParams);

            if (is_string($routeAction)) {
                [$controllerName, $actionName] = explode('@', $routeAction);
                $controller = new $controllerName();
                return $controller->$actionName(...$routeActionParams);
            }

            if (is_array($routeAction)) {
                [$controllerName, $actionName] = $routeAction;
                $controller = new $controllerName();
                return $controller->$actionName(...$routeActionParams);
            }

            if ($routeAction instanceof \Closure) {
                return $routeAction(...$routeActionParams);
            }

            return null;
        };

        foreach (array_reverse($middlewares) as $middleware) {
            $middlewareInstance = is_string($middleware) ? new $middleware() : $middleware;
            $next = function ($request) use ($middlewareInstance, $next) {
                return $middlewareInstance->handle($request, $next);
            };
        }

        return $next($request);
    }

    public function getRoutePrefix(): string
    {
        $currentPrefix = '/' . implode('/', $this->routePrefixes);

        if ($currentPrefix === '/') {
            $currentPrefix = '';
        }

        return $currentPrefix;
    }

    public function getRouteByName(string $name): ?Route
    {
        foreach ($this->routes as $methodRoutes) {
            foreach ($methodRoutes as $route) {
                if ($route->getName() === $name) {
                    return $route;
                }
            }
        }

        return null;
    }

    public function generateUrl(string $name, array $params = []): ?string
    {
        $route = $this->getRouteByName($name);
        if (!$route) {
            return null;
        }

        $pattern = $route->getDetails()['pattern'];
        foreach ($params as $key => $value) {
            $pattern = preg_replace('/{' . $key . '}/', $value, $pattern);
        }

        $pattern = preg_replace('/{[^\/]+}/', '', $pattern);
        $pattern = rtrim($pattern, '/');

        return $pattern === '' ? '/' : $pattern;
    }
}