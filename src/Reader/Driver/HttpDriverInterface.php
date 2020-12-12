<?php

namespace Ahoraian\Feed\Reader\Driver;

interface HttpDriverInterface
{
    /**
     * fetch a url
     *
     * @param $url
     * @param \DateTime|null $lastModified
     * @return mixed
     */
    public function getResponse($url, \DateTime $lastModified = null);
}