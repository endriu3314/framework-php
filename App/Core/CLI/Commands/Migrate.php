<?php

namespace App\Core\CLI\Commands;

use App\Core\CLI\CommandController;
use App\Core\Helpers\FileHelper;
use App\Core\Helpers\StringHelper;

class Migrate extends CommandController
{
    public $name = 'migrate';
    public $help = 'Run migrations';
    public $usage = 'php cli migrate App/Migrations';

    public function run($argv)
    {
        $printer = $this->getApp()->getPrinter();

        $path = $argv[2] ?? "App" . DIRECTORY_SEPARATOR . "Migrations";

        $printer->display('Migrations to run:', 'white');
        $printer->newline(2);

        $migrations = FileHelper::getFilesRecursive($path);

        foreach ($migrations as $migration) {
            $printer->display('- ');
            $printer->display(StringHelper::removeExtension($migration), 'green');
            $printer->newline();
        }

        $printer->newline();
        $printer->display('Do you want to run the migrations? ', 'yellow');
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

        foreach ($migrations as $migration) {
            include $migration;
        }
    }
}
