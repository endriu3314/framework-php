<?php

namespace App\Commands;

use App\Core\CLI\CommandController;
use App\Helpers\StringHelper;

class Migrate extends CommandController
{
    public function run($argv)
    {
        $printer = $this->getApp()->getPrinter();

        $printer->display('Migrations to run:', 'white');

        $printer->newline(2);

        $migrations = scandir('App/Migrations');

        for ($counter = 2; $counter < count($migrations); $counter++) {
            $printer->display('- ', 'white');
            $printer->display(StringHelper::removeExtension($migrations[$counter]), 'green');
            $printer->newline();
        }

        $printer->newline();
        $printer->display('Do you want to run the migrations? ', 'yellow');
        $printer->display('[yes/no] ', 'green');
        $printer->display('no ', 'white');

        $handle = fopen('php://stdin', 'r');
        $line = fgets($handle);

        if (trim($line) != 'yes') {
            $printer->newline();
            $printer->display('Aborting!', 'red');
            exit;
        }

        fclose($handle);

        for ($counter = 2; $counter < count($migrations); $counter++) {
            include 'App/Migrations/'.$migrations[$counter];
        }
    }
}
