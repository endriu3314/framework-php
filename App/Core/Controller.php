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

    /**
     * Used to initialize the redirect
     * @return $this
     */
    public function redirect(): Controller
    {
        $this->redirect = true;
        return $this;
    }

    /**
     * Set redirect route
     *
     * @param string $url
     * @param int $statusCode
     *
     * @return $this
     */
    public function url(string $url, $statusCode = 303): Controller
    {
        $this->url = $url;
        return $this;
    }

    /**
     * User this to set the redirect route to go back from where it came from
     * @return $this
     */
    public function back(): Controller
    {
        $this->url = $_SERVER['HTTP_REFERER'];
        return $this;
    }

    /**
     * Redirect user with previous set parameters
     */
    public function do(): void
    {
        header("Location: {$this->url}", true, $this->statusCode);
        exit();
    }


    /**
     * Simply implement the validator in a Controller using an array
     *
     * @param array $validate
     *
     * @return bool
     */
    public function validate(array $validate): bool
    {
        $isValid = true;

        foreach ($validate as $value => $rules) {
            if (! Validator::is($value, $rules, $this->validateErrors)) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
