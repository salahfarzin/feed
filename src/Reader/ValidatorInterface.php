<?php

namespace Ahoraian\Feed\Reader;

/**
 * Validate documents
 * Interface Validator
 * @package namespace Atom\FeedBundle;\Reader
 */
interface ValidatorInterface
{
    /**
     * Validate document for some node exists
     *
     * @return mixed
     */
    public function validate();
}