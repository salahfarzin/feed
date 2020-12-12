<?php

namespace Ahoraian\Feed\Reader\Driver;

interface ResponseInterface
{
    /**
     * Retrieve the response body
     *
     * @return string
     */
    public function getBody();

    /**
     * Retrieve the HTTP response status code
     *
     * @return int
     */
    public function getStatusCode();

    /**
     * Retrieve the HTTP response headers
     *
     * @return array
     */
    public function getHeaders();
}