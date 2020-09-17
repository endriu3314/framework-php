<?php

namespace App\Routes;

use App\Core\Router\Request;
use App\Core\Router\Router;
use App\Http\Controllers\home;

class routes
{
    public function __construct()
    {
        $router = new Router(new Request());

        $router->get('/home/', function () {
            $home = new home();
            return $home->index();
        });

        $router->get('/example_one', function () {
            $home = new home();
            return $home->exampleOne();
        });

        $router->get('/books/', function () {
            $home = new home();
            return $home->post();
        });
    }

}
