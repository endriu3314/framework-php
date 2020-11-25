<?php

namespace App\Core;

abstract class Controller
{
    public function sanitize(string $var): string
    {
        return strip_tags($var);
    }
}
