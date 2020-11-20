<?php

namespace App\Core\Http;

use App\Helpers\Validator;

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
    public function setUrl(string $url)
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
    public function setHeader(array $headers)
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
    public function setBody(array $body)
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
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Function to launch POST.
     *
     * @return string - Response from URL
     */
    public function post()
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
    public function get()
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
