<?php

namespace App\Core\Http;

use App\Core\Helpers\Validator;

/**
 * Class Request
 * Used to generate CURL requests.
 */
class Request
{
    /* @var $url string - String with the URL to request to */
    private $url;
    /* @var $options array - CURL Options for Request */
    private $options;
    /* @var $headers array - Headers for request */
    private $headers;
    /* @var $body array - Body | Only used in POST requests */
    private $body;

    /**
     * Set URL for request.
     *
     * @param string $url - URL
     *
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set Headers for request.
     *
     * @param array $headers - Headers
     *
     * @return $this
     */
    public function setHeader(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set Body for request.
     *
     * @param array $body
     *
     * @return $this
     */
    public function setBody(array $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Set CURL options for request.
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Function to launch POST.
     *
     * @return string - Response from URL
     */
    public function post(): string
    {
        if (Validator::isNone($this->options)) {
            $this->options = [];
        }

        if (Validator::isNone($this->headers)) {
            $this->headers = [];
        }

        $request = new Post($this->url, $this->options, $this->headers);

        return $request($this->body);
    }

    /**
     * Function to launch GET.
     *
     * @return string - Response from URL
     */
    public function get(): string
    {
        if (Validator::isNone($this->options)) {
            $this->options = [];
        }

        if (Validator::isNone($this->headers)) {
            $this->headers = [];
        }

        $request = new Get($this->url, $this->options, $this->headers);

        return $request();
    }
}
