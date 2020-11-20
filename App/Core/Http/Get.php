<?php

namespace App\Core\Http;

use RuntimeException;

class Get
{
    private $url;
    private $options;
    private $headers;

    public function __construct($url, $options = [], $headers = [])
    {
        $this->url = $url;
        $this->options = $options;
        $this->headers = $headers;
    }

    public function __invoke()
    {
        $ch = curl_init($this->url);

        curl_setopt_array($ch, $this->options);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response  = curl_exec($ch);
        $error = curl_error($ch);
        $errno = curl_errno($ch);

        if (is_resource($ch)) {
            curl_close($ch);
        }

        if ($errno !== 0) {
            throw new RuntimeException($error, $$errno);
        }

        return $response;
    }
}
