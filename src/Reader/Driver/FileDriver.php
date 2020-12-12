<?php

namespace Ahoraian\Feed\Reader\Driver;

use Ahoraian\Feed\Reader\Exception\RuntimeException;

class FileDriver implements HttpDriverInterface
{

    /**
     * return String response
     *
     * @inheritDoc
     */
    public function getResponse($url, \DateTime $lastModified = null)
    {
        if (!is_readable($url)) {
            throw new RuntimeException("{$url} is not reachable}");
        }

        $body = file_get_contents($url);

        $response = new Response();
        $response->setStatusCode(200);
        $response->setBody($body);

        return $response;
    }
}