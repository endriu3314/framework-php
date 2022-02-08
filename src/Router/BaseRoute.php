<?php

namespace AndreiCroitoru\FrameworkPhp\Router;

/**
 * Class BaseRoute
 * Define a Base Route object for the Router.
 */
class BaseRoute
{
    /* @var string */
    private string $model;
    /* @var string */
    private string $controller;
    /* @var string */
    private string $action;
    /* @var string */
    private string $middleware;

    /**
     * BaseRoute constructor.
     *
     * @param string $model - Model for route
     * @param string $controller
     * @param string $action
     * @param string $middleware
     */
    public function __construct(string $model = '', string $controller = '', string $action = '', string $middleware = '')
    {
        $this->model = $model;
        $this->controller = $controller;
        $this->action = $action;
        $this->middleware = $middleware;
    }

    /**
     * Return Route Model if exists.
     *
     * @return string|null
     */
    public function getModel(): ?string
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
    public function getController(): ?string
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
    public function getAction(): ?string
    {
        if ($this->action == '') {
            return null;
        }

        return $this->action;
    }

    /**
     * Return Middleware if exists.
     *
     * @return string|null
     */
    public function getMiddleware(): ?string
    {
        if ($this->middleware == '') {
            return null;
        }

        return $this->middleware;
    }
}
