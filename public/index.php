<?php

use App\Core\Application;
use App\Core\Config;
use App\Core\Router\Router;

define('ROOT', dirname(__DIR__).DIRECTORY_SEPARATOR);
define('APP', ROOT.'App'.DIRECTORY_SEPARATOR);

define('CONFIG', APP.'Config'.DIRECTORY_SEPARATOR);
define('CORE', APP.'Core'.DIRECTORY_SEPARATOR);
define('HELPER', APP.'Helpers'.DIRECTORY_SEPARATOR);
define('HTTP', APP.'Http'.DIRECTORY_SEPARATOR);

define('CONTROLLER', HTTP.'Controllers'.DIRECTORY_SEPARATOR);
define('MODEL', HTTP.'Model'.DIRECTORY_SEPARATOR);
define('VIEW', HTTP.'Views'.DIRECTORY_SEPARATOR);

require CONFIG.'app.php';

spl_autoload_register(function ($class) {
    include ROOT.str_replace('\\', '/', $class).'.php';
});

function exception_handler($exception)
{
    include CORE.'/ExceptionHandler/template.php';
}

set_exception_handler('exception_handler');

$routes = '';

if (extension_loaded('yaml')) {
    $routes = '../routes.yml';
} elseif (extension_loaded('json')) {
    $routes = '../routes.json';
}

$router = new Router(new Config($routes));

$app = new Application($router);
$app->run();
