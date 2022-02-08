<?php

namespace AndreiCroitoru\FrameworkPhp;

abstract class Middleware
{
    public function redirect($url, $statusCode = 303): void
    {
        header('Location: ' . $url, true, $statusCode);
        exit();
    }

    public function run(): void
    {
    }
}
