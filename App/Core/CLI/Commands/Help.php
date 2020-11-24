<?php

namespace App\Core\CLI\Commands;

use App\Core\CLI\CommandController;
use App\Core\Helpers\FileHelper;
use App\Core\Helpers\StringHelper;

class Help extends CommandController
{
    public $name = 'help';
    public $help = 'Display all commands';

    private $customCommandsPath = 'App\Commands\\';
    private $coreCommandsPath = 'App\Core\CLI\Commands\\';

    public function run($argv)
    {
        $customCommands = [];
        $coreCommands = [];

        foreach (FileHelper::getFiles($this->customCommandsPath) as $key => $value) {
            $customCommands[$value] = $this->customCommandsPath;
        }

        foreach (FileHelper::getFiles($this->coreCommandsPath) as $key => $value) {
            $coreCommands[$value] = $this->coreCommandsPath;
        }

        $commands = array_merge($customCommands, $coreCommands);

        $this->getApp()->getPrinter()->display('Available commands:', 'blue');
        $this->getApp()->getPrinter()->newline(2);

        $this->displayCommands($commands);
    }

    /**
     * Display commands in terminal.
     *
     * @param array $commands - Commands array with "Name" => "Path"
     */
    private function displayCommands(array $commands): void
    {
        foreach ($commands as $command => $path) {
            $className = StringHelper::removeExtension($command);
            $classPath = $path.$className;
            $commandClassObject = new $classPath($this->getApp());

            $commandName = $commandClassObject->name ?? $className;
            $commandHelp = $commandClassObject->help ?? '';

            $this->getApp()->getPrinter()->display("• {$commandName}", 'yellow');
            $this->getApp()->getPrinter()->display(' - ', 'light_green');
            $this->getApp()->getPrinter()->display($commandHelp, 'green');
            $this->getApp()->getPrinter()->newline();
        }
    }
}
