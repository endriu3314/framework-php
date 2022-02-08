<?php

namespace AndreiCroitoru\FrameworkPhp\CLI\Commands;

use AndreiCroitoru\FrameworkPhp\CLI\CommandController;
use AndreiCroitoru\FrameworkPhp\Helpers\FileHelper;

class Make extends CommandController
{
    public $name = 'make';
    public $help = 'Make command/controller/model/template/migration';

    public function run($argv)
    {
        $printer = $this->getApp()->getPrinter();

        $types = [
            'model'      => 'php',
            'controller' => 'php',
            'command'    => 'php',
            'template'   => 'html',
            'migration'  => 'php',
            'middleware' => 'php',
        ];

        $paths = [
            'model'      => 'App/Http/Model/',
            'controller' => 'App/Http/Controllers/',
            'command'    => 'App/Commands/',
            'template'   => 'templates/',
            'migration'  => 'App/Migrations/',
            'middleware' => 'App/Http/Middleware/',
        ];

        if (!isset($argv[2])) {
            $printer->display('Type required', 'red');
            $printer->newline();

            return;
        }
        if (!isset($argv[3])) {
            $printer->display('Name required', 'red');
            $printer->newline();

            return;
        }

        $type = $argv[2];
        $name = $argv[3];

        $files = FileHelper::getFiles(__DIR__ . '/make');

        if (!in_array($type, $files, true)) {
            $printer->display('Type not found', 'red');
            $printer->newline();
            $printer->display('Please use one of the following: ', 'yellow');
            foreach ($files as $file) {
                $printer->display($file, 'green');
                $printer->display('/');
            }

            return;
        }

        $content = file_get_contents(__DIR__ . '/make/' . $type);
        $content = str_replace('#NAME#', $name, $content);

        $prefix = '';

        if ($type === 'migration') {
            $prefix = date('YmdHis') . "_";
        }

        $file = "$paths[$type]$prefix$name.$types[$type]";

        if (file_exists($file)) {
            $printer->display('[✘] ', 'red');
            $printer->display("$file already exists");

            return;
        }

        if (!is_dir($paths[$type])) {
            mkdir($paths[$type]);
        }

        if (!file_put_contents($file, $content, FILE_APPEND | LOCK_EX)) {
            $printer->display('[✘] ', 'red');
            $printer->display("$file was not created");

            return;
        }

        $printer->display('[✔] ', 'green');
        $printer->display("$file was created");
    }
}
