<?php

namespace App\Core\CLI;

abstract class CommandController
{
    protected $app;

    abstract public function run($argv);

    public function __construct(CLI $app)
    {
        $this->app = $app;
    }

    protected function getApp(): CLI
    {
        return $this->app;
    }
}
