<?php

namespace AndreiCroitoru\FrameworkPhp\CLI;

class CLI
{
    protected CLIHelper $printer;
    protected CommandRegistry $command_registry;

    public function __construct()
    {
        $this->printer = new CLIHelper();
        $this->command_registry = new CommandRegistry();
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
