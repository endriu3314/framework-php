<?php

namespace AndreiCroitoru\FrameworkPhp\CLI;

use AndreiCroitoru\FrameworkPhp\Exceptions\CliException;

class CommandRegistry
{
    protected array $registry = [];
    protected array $controllers = [];

    public function registerController(string $command_name, CommandController $controller): void
    {
        $this->controllers[$command_name] = $controller;
    }

    public function registerCommand(string $name, callable $callable): void
    {
        $this->registry[$name] = $callable;
    }

    public function getControllers(): array
    {
        return $this->controllers;
    }

    public function getController(string $command)
    {
        return $this->controllers[$command] ?? null;
    }

    public function getCommand(string $command)
    {
        return $this->registry[$command] ?? null;
    }

    public function getCallable(string $command_name)
    {
        $controller = $this->getController($command_name);

        if ($controller instanceof CommandController) {
            return [$controller, 'run'];
        }

        $command = $this->getCommand($command_name);
        if ($command === null) {
            throw new CliException("Command {$command_name} not found.");
        }

        return $command;
    }
}
