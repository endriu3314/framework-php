<?php

namespace App\Core;

use App\Core\Helpers\Validator;

abstract class Controller
{
    protected bool $redirect;
    protected string $url;
    protected int $statusCode;

    public array $validateErrors = [];

    public function sanitize(string $var): string
    {
        return strip_tags($var);
    }

    public function redirect(): Controller
    {
        $this->redirect = true;
        return $this;
    }

    public function url(string $url, $statusCode = 303): Controller
    {
        $this->url = $url;
        return $this;
    }

    public function back(): Controller
    {
        $this->url = $_SERVER['HTTP_REFERER'];
        return $this;
    }

    public function do(): void
    {
        header("Location: $this->url", true, $this->statusCode);
        exit();
    }


    public function validate(array $validate): bool
    {
        $isValid = true;

        foreach ($validate as $value => $rules) {
            if (!Validator::is($value, $rules, $this->validateErrors)) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
