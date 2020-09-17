<?php

namespace App\Routes;

use App\Core\Router\Request;
use App\Core\Router\Router;
use App\Http\Controllers\HomeController;

class routes
{
    public function __construct()
    {
        $router = new Router(new Request());

        $router->get('/home', function () {
            $home = new HomeController();
            return $home->index();
        });

        $router->get('/example_one', function () {
            $home = new HomeController();
            return $home->exampleOne();
        });

        $router->get('/books/', function () {
            $home = new HomeController();
            return $home->post();
        });
    }

}
