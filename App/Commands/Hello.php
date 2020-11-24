<?php

namespace App\Commands;

use App\Core\CLI\CommandController;

class Hello extends CommandController
{
    public $name = 'hello';
    public $help = 'Info about hello Command';

    public function run($argv)
    {
        $name = isset($argv[2]) ? $argv[2] : 'World';
        $this->getApp()->getPrinter()->display("Hello $name!!!");
    }
}
