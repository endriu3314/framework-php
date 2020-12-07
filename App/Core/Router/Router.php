<?php

namespace App\Core\Router;

use App\Core\Config;

/**
 * Class Router
 * Handle Routes and Route matches in Application.
 */
class Router
{
    /* @var array - Array of existing routes */
    private array $routes;

    /**
     * Router constructor.
     * Reads YAML file and maps routes to class property.
     *
     * @param Config $routes
     */
    public function __construct(Config $routes)
    {
        $this->routes = [];

        $routesData = $routes->getData();

        foreach ($routesData['routes'] as $route) {
            $url = $route['url'];
            $method = $route['method'];
            $middleware = $route['middleware'] ?? '';
            $model = $route['model'] ?? '';

            $controller = '';
            $action = '';
            if (isset($route['controller'])) {
                $controller = $route['controller'];

                if (isset($route['action'])) {
                    $action = $route['action'];
                }
            }

            $this->routes[$method][$url] = new BaseRoute($model, $controller, $action, $middleware);
        }
    }

    /**
     * Match request with routes
     * Check if requested route exists, then return it
     * If not return null.
     *
     * @param string $request
     * @param string $requestMethod
     *
     * @return mixed - Return route/null
     */
    public function match(string $request, string $requestMethod): mixed
    {
        return $this->routes[$requestMethod][$request] ?? null;
    }
}
