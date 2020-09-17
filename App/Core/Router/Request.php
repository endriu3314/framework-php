<?php

namespace App\Core\Router;

use App\Helpers\StringHelper;

class Request implements IRequest
{
    public $requestMethod;
    public $requestUri;
    public $serverProtocol;

    public function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{StringHelper::toCamelCase($key)} = $value;
        }
    }

    public function getBody()
    {
        if ($this->requestMethod === "GET") {
            return;
        }

        if ($this->requestMethod == "POST") {
            $body = array();

            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $body;
        }
    }
}
