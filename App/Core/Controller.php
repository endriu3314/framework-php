<?php

namespace App\Core;

use App\Core\Helpers\Validator;

abstract class Controller
{
    protected $redirect;
    protected $url;
    protected $statusCode;

    public $validateErrors = [];

    public function sanitize(string $var): string
    {
        return strip_tags($var);
    }

    public function redirect()
    {
        $this->redirect = true;
        return $this;
    }

    public function url($url, $statusCode = 303)
    {
        $this->url = $url;
        return $this;
    }

    public function back()
    {
        $this->url = $_SERVER['HTTP_REFERER'];
        return $this;
    }

    public function do()
    {
        header("Location: $this->url", true, $this->statusCode);
        exit();
    }


    public function validate(array $validate): bool
    {
        foreach ($validate as $value => $rules) {
            if (!Validator::is($value, $rules, $this->validateErrors)) {
                return false;
            }
        }

        return true;
    }
}
