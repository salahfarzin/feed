<?php

namespace Ahoraian\Feed\Reader\Driver;

class Response implements ResponseInterface
{
    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $httpVersion;

    /**
     * @var string
     */
    protected $httpMessage;

    /**
     * @return int|void
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return ResponseInterface
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = (int)$statusCode;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     *
     * @return ResponseInterface
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return ResponseInterface
     */
    public function setBody(string $body)
    {
        $this->body = $body;

        return $this;
    }
}