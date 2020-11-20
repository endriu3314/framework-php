<?php

namespace App\Core\Router;

use App\Core\Config;

/**
 * Class Router
 * Handle Routes and Route matches in Application
 */
class Router
{
    /* @var array - Array of existing routes */
    private $routes;

    /**
     * Router constructor.
     * Reads YAML file and maps routes to class property
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

            $model = '';
            $controller = '';
            $action = '';

            if (isset($route['model'])) {
                $model = $route['model'];
            }

            if (isset($route['controller'])) {
                $controller = $route['controller'];

                if (isset($route['action'])) {
                    $action = $route['action'];
                }
            }

            $this->routes[$method][$url] = new BaseRoute($model, $controller, $action);
        }
    }

    /**
     * Match request with routes
     * Check if requested route exists, then return it
     * If not return null
     *
     * @param string $request
     * @param string $requestMethod
     *
     * @return mixed|null - Return route/null
     */
    public function match(string $request, string $requestMethod)
    {
        if (isset($this->routes[$requestMethod][$request])) {
            return $this->routes[$requestMethod][$request];
        }

        return null;
    }
}
