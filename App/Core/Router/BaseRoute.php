<?php

namespace App\Core\Router;

/**
 * Class BaseRoute
 * Define a Base Route object for the Router.
 */
class BaseRoute
{
    /* @var string */
    private $model;
    /* @var string */
    private $controller;
    /* @var string */
    private $action;

    /**
     * BaseRoute constructor.
     *
     * @param string $model      - Model for route
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $model = '', string $controller = '', string $action = '')
    {
        $this->model = $model;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * Return Route Model if exists.
     *
     * @return string|null
     */
    public function getModel()
    {
        if ($this->model == '') {
            return null;
        }

        return $this->model;
    }

    /**
     * Return Route Controller if exists.
     *
     * @return string|null
     */
    public function getController()
    {
        if ($this->controller == '') {
            return null;
        }

        return $this->controller;
    }

    /**
     * Return Route Action if exists.
     *
     * @return string|null
     */
    public function getAction()
    {
        if ($this->action == '') {
            return null;
        }

        return $this->action;
    }
}
