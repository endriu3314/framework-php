<?php

namespace AndreiCroitoru\FrameworkPhp\CLI;

use AndreiCroitoru\FrameworkPhp\Helpers\FileHelper;
use AndreiCroitoru\FrameworkPhp\Helpers\StringHelper;

class CLI
{
    protected CLIHelper $printer;
    protected CommandRegistry $command_registry;

    public function __construct()
    {
        $this->printer = new CLIHelper();
        $this->command_registry = new CommandRegistry();
        $this->registerCoreCommands();
    }

    private function registerCoreCommands(): void
    {
        $commands = FileHelper::getFiles(__DIR__ . '/Commands');

        foreach ($commands as $command) {
            $className = StringHelper::removeExtension($command);
            $classPath = __NAMESPACE__ . '\\Commands\\' . $className;
            $commandClassObject = new $classPath($this);

            $commandName = $commandClassObject->name ?? $className;

            $this->registerController($commandName, $commandClassObject);
        }
    }

    public function getCommandRegistry(): CommandRegistry
    {
        return $this->command_registry;
    }

    public function getPrinter(): CLIHelper
    {
        return $this->printer;
    }

    public function registerController(string $name, CommandController $controller): void
    {
        $this->command_registry->registerController($name, $controller);
    }

    public function registerCommand(string $name, callable $callable): void
    {
        $this->command_registry->registerCommand($name, $callable);
    }

    public function runCommand(array $argv = [], string $default_command = 'help'): void
    {
        $command_name = $argv[1] ?? $default_command;

        try {
            call_user_func($this->command_registry->getCallable($command_name), $argv);
        } catch (\Exception $e) {
            $this->getPrinter()->display("ERROR: {$e->getMessage()}");
            exit;
        }
    }
}
