<?php

include CORE . 'Config.php';

$config = new App\Core\Config('../config.yml');
$configData = $config->getData();

define('ENVIRONMENT', $configData["environment"] ?? 'dev');
define('DEBUG', $configData["debug"] ?? true);

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', '//');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

define('DB_TYPE', $configData["database"]["type"] ?? 'mysql');
define('DB_HOST', $configData["database"]["host"] ?? '127.0.0.1');
define('DB_NAME', $configData["database"]["database"] ?? 'atestat');
define('DB_USER', $configData["database"]["user"] ?? 'root');
define('DB_PASS', $configData["database"]["password"] ?? '');
define('DB_CHARSET', $configData["database"]["charset"] ?? 'utf8');
