<?php

namespace App\Core\Http;

use App\Core\Exceptions\HttpException;

/**
 * Class Get
 * Used to create a CURL GET request.
 */
class Get
{
    /* @var $url string - String with the URL to request to */
    private $url;
    /* @var $options array - CURL Options for Request */
    private $options;
    /* @var $headers array - Headers for request */
    private $headers;

    /**
     * Get constructor.
     *
     * @param string $url     - URL To make request to
     * @param array  $options - CURL Options
     * @param array  $headers - Headers for request
     */
    public function __construct(string $url, array $options = [], array $headers = [])
    {
        $this->url = $url;
        $this->options = $options;
        $this->headers = $headers;
    }

    /**
     * The CURL request runs in here, when the class is invoked.
     *
     * @return string
     */
    public function __invoke()
    {
        $ch = curl_init($this->url);

        curl_setopt_array($ch, $this->options);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $errno = curl_errno($ch);

        if (is_resource($ch)) {
            curl_close($ch);
        }

        if ($errno !== 0) {
            throw new HttpException($error, $$errno);
        }

        return (string) $response;
    }
}
