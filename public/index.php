<?php

use App\Core\Application;
use App\Core\Config;
use App\Core\Router\Router;

define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
define("APP", ROOT . "App" . DIRECTORY_SEPARATOR);

define("CONFIG", APP . "config" . DIRECTORY_SEPARATOR);
define("CORE", APP . "Core" . DIRECTORY_SEPARATOR);
define("HELPER", APP . "Helpers" . DIRECTORY_SEPARATOR);
define("HTTP", APP . "Http" . DIRECTORY_SEPARATOR);

define("CONTROLLER", HTTP . "Controllers" . DIRECTORY_SEPARATOR);
define("MODEL", HTTP . "Model" . DIRECTORY_SEPARATOR);
define("VIEW", HTTP . "Views" . DIRECTORY_SEPARATOR);

require CONFIG . "app.php";

spl_autoload_register(function ($class) {
    include ROOT . str_replace('\\', '/', $class) . '.php';
});

$router = new Router(new Config("../routes.yml"));

$app = new Application($router);
$app->run();
