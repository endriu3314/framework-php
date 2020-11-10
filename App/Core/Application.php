<?php

namespace App\Core;

use App\Core\Router\BaseRoute;
use App\Core\Router\Router;

class Application
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run()
    {
        $request = $_SERVER['REQUEST_URI'];

        if ($request != '/') {
            $request = rtrim($request, '/');
        }

        $route = $this->router->match($request, $_SERVER['REQUEST_METHOD']);

        if ($route == null) {
            http_response_code(404);
            require VIEW.'404.php';
        } else {
            $this->initiate($route);
        }
    }

    private function initiate(BaseRoute $route)
    {
        $model = null;
        $modelName = $route->getModel();
        if ($modelName != null) {
            $model = new $modelName();
        }

        $controller = null;
        $controllerName = $route->getController();
        if ($controllerName != null) {
            $controller = new $controllerName($model);

            $actionName = $route->getAction();
            if ($actionName != null) {
                $controller->$actionName();
            }
        }
    }
}
