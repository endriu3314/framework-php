<?php

namespace App\Core\CLI\Commands;

use App\Core\CLI\CommandController;
use App\Core\Helpers\FileHelper;

class Auth extends CommandController
{
    public $name = 'auth';
    public $help = 'Publish auth & register scaffolding';

    public function run($argv)
    {
        $printer = $this->getApp()->getPrinter();

        $basePath = 'App' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'CLI' . DIRECTORY_SEPARATOR . 'Commands' . DIRECTORY_SEPARATOR . 'auth' . DIRECTORY_SEPARATOR;
        $paths = [
            'controller' => $basePath . 'Controller' . DIRECTORY_SEPARATOR,
            'model' => $basePath . 'Model' . DIRECTORY_SEPARATOR,
            'middleware' => $basePath . 'Middleware' . DIRECTORY_SEPARATOR,
            'migration' => $basePath . 'Migration' . DIRECTORY_SEPARATOR,
            'view' => $basePath . 'View' . DIRECTORY_SEPARATOR,
        ];

        $httpBasePath = 'App' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR;
        $writeToPaths = [
            'controller' => $httpBasePath . 'Controllers' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR,
            'model' => $httpBasePath . 'Model' . DIRECTORY_SEPARATOR,
            'middleware' => $httpBasePath . 'Middleware' . DIRECTORY_SEPARATOR,
            'migration' => 'App' . DIRECTORY_SEPARATOR . 'Migrations' . DIRECTORY_SEPARATOR,
            'view' => 'templates' . DIRECTORY_SEPARATOR,
        ];

        $printer->newline();
        $printer->display('Do you want to publish auth scaffolding? ', 'yellow');
        $printer->display('[yes/', 'green');
        $printer->display('no');
        $printer->display('] ', 'green');

        $handle = fopen('php://stdin', 'rb');
        $line = fgets($handle);

        $yes = [
            'yes',
            'YES',
            'y',
            'Y',
        ];

        if (!in_array(trim($line), $yes)) {
            $printer->newline();
            $printer->display('Aborting!', 'red');
            return;
        }

        foreach ($writeToPaths as $path) {
            if (!is_dir($path)) {
                if (!mkdir($path)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
                }
            }
        }

        $controllers = FileHelper::getFiles($paths['controller']);
        $models = FileHelper::getFiles($paths['model']);
        $middlewares = FileHelper::getFiles($paths['middleware']);
        $migrations = FileHelper::getFiles($paths['migration']);
        $views = FileHelper::getFiles($paths['view']);

        $contents = [
            'controller' => $controllers,
            'model' => $models,
            'middleware' => $middlewares,
            'migration' => $migrations,
            'view' => $views,
        ];

        $file_content = file_get_contents($basePath . 'routes');
        $file = 'routes.yml';

        $routes_content = file_get_contents($file);

        if (strpos($routes_content, $file_content)) {
            $printer->display('[✘] ', 'red');
            $printer->display('Routes already exist');
        } else {
            if (!file_put_contents($file, $file_content, FILE_APPEND | LOCK_EX)) {
                $printer->display('[✘] ', 'red');
                $printer->display("{$file} was not created");
            } else {
                $printer->display('[✔] ', 'green');
                $printer->display('Routes added');
            }
        }

        $printer->newline();

        foreach ($contents as $type => $content) {
            foreach ($content as $file) {
                $file_content = file_get_contents($paths[$type] . $file);
                $file = $writeToPaths[$type] . $file;

                if (file_exists($file)) {
                    $printer->display('[✘] ', 'red');
                    $printer->display("{$file} already exists");
                } elseif (!file_put_contents($file, $file_content, LOCK_EX)) {
                    $printer->display('[✘] ', 'red');
                    $printer->display("{$file} was not created");
                } else {
                    $printer->display('[✔] ', 'green');
                    $printer->display("{$file} was created");
                }
                $printer->newline();
            }
        }
    }
}
