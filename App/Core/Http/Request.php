<?php

namespace App\Core\Http;

use App\Helpers\Validator;

class Request
{
    private $url;
    private $headers;
    private $options;
    private $body;

    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function setHeader(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function setBody(array $body)
    {
        $this->body = $body;
        return $this;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function post()
    {
        if (Validator::isNone($this->options))
            $this->options = [];

        if (Validator::isNone($this->headers))
            $this->headers = [];

        $request = new Post($this->url, $this->options, $this->headers);

        return $request($this->body);
    }

    public function get()
    {
        if (Validator::isNone($this->options))
            $this->options = [];

        if (Validator::isNone($this->headers))
            $this->headers = [];

        $request = new Get($this->url, $this->options, $this->headers);

        return $request();
    }
}
