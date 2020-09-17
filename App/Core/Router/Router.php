<?php

namespace App\Core\Router;

use Exception;

class Router
{
    private $request;

    public function __construct(IRequest $request)
    {
        $this->request = $request;
    }

    public function __call($name, $args)
    {
        list($route, $method) = $args;

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    private function defaultRequestHandler()
    {
        header("{$this->request->serverProtocol} 404 Not Found");
        require VIEW . "404.php";
    }

    public function resolve()
    {
        try {
            $methodDictionary = $this->{strtolower($this->request->requestMethod)};
            $formattedRoute = $this->formatRoute($this->request->requestUri);
            $method = $methodDictionary[$formattedRoute];

            if (DEBUG) {
                echo "<div style='font-size: 1rem; display: inline-block; background-color: #f3f3f3; border: 1px solid #ddd; min-width: 230px; padding: 1rem 1rem 1rem 1rem; font-family: monospace;'>";
                echo "<span style='font-weight: bold; color: #222222; font-size: 2rem; width: 100%'>Link trace</span>" . "<br />";
                //echo "<span style='font-weight: bold; color: #5c5c5c'>MethodDictionary: </span>"; print_r($methodDictionary); echo "<br />";
                echo "<span style='font-weight: bold; color: #5c5c5c'>Method: </span>" . $this->request->requestMethod . "<br />";
                echo "<span style='font-weight: bold; color: #5c5c5c'>Original Route: </span>" . $this->request->requestUri . "<br />";
                echo "<span style='font-weight: bold; color: #5c5c5c'>Method: </span>"; print_r($method); echo "<br />";
                echo "</div>";
            }

            if (is_null($method)) {
                $this->defaultRequestHandler();
                return;
            }
            echo call_user_func_array($method, array($this->request));

        } catch (Exception $e) {

        }
    }

    public function __destruct()
    {
        $this->resolve();
    }
}
