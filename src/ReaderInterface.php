<?php

namespace Ahoraian\Feed;

interface ReaderInterface
{
    /**
     * Load a feed from a remote URI
     *
     * @param $uri
     * @param \DateTime|null $lastModifiedDate
     */
    public function load($uri, \DateTime $lastModifiedDate = null);
}