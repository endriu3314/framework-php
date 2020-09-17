<?php

namespace App\Core;

use App\Routes\routes;

class Application
{
    public function __construct()
    {
        new routes();
    }
}
