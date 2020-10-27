<?php

namespace App\Core\Router;

class BaseRoute
{
    private $view;
    private $model;
    private $controller;
    private $action;

    public function __construct(string $view, string $model = "", string $controller = "", string $action = "")
    {
        $this->view = $view;
        $this->model = $model;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function getView()
    {
        if ($this->view == "")
            return null;

        return $this->view;
    }

    public function getModel()
    {
        if ($this->model == "")
            return null;

        return $this->model;
    }

    public function getController()
    {
        if ($this->controller == "")
            return null;

        return $this->controller;
    }

    public function getAction()
    {
        if ($this->action == "")
            return null;

        return $this->action;
    }
}
