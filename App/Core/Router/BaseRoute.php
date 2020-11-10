<?php

namespace App\Core\Router;

class BaseRoute
{
    private $model;
    private $controller;
    private $action;

    public function __construct(string $model = '', string $controller = '', string $action = '')
    {
        $this->model = $model;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function getModel()
    {
        if ($this->model == '') {
            return null;
        }

        return $this->model;
    }

    public function getController()
    {
        if ($this->controller == '') {
            return null;
        }

        return $this->controller;
    }

    public function getAction()
    {
        if ($this->action == '') {
            return null;
        }

        return $this->action;
    }
}
