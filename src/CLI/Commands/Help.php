<?php

namespace AndreiCroitoru\FrameworkPhp\CLI\Commands;

use AndreiCroitoru\FrameworkPhp\CLI\CommandController;

class Help extends CommandController
{
    public $name = 'help';
    public $help = 'Display all commands';

    private $customCommandsPath = './App/Commands/';
    private $coreCommandsPath = './App/Core/CLI/Commands/';

    public function run($argv)
    {
        $this->getApp()->getPrinter()->display('Available commands:', 'blue');
        $this->getApp()->getPrinter()->newline(2);

        foreach ($this->getApp()->getCommandRegistry()->getControllers() as $controller) {
            $this->displayCommandInfo($controller);
        }
    }

    private function displayCommandInfo(CommandController $controller): void
    {
        $commandName = $controller->name ?? get_class($controller);
        $commandHelp = $controller->help ?? '';
        $commandUsage = $controller->usage ?? '';

        $this->getApp()->getPrinter()->display("• $commandName", 'yellow');

        if ($commandHelp !== '') {
            $this->getApp()->getPrinter()->display(' - ', 'light_green');
            $this->getApp()->getPrinter()->display($commandHelp, 'green');
        }

        if ($commandUsage !== '') {
            $this->getApp()->getPrinter()->newline();
            $this->getApp()->getPrinter()->display('Usage: ');
            $this->getApp()->getPrinter()->display($commandUsage, 'yellow');
        }

        $this->getApp()->getPrinter()->newline();
    }
}
