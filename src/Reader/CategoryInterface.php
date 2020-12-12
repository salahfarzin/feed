<?php

namespace Ahoraian\Feed\Reader;

interface CategoryInterface
{
    /**
     * Get entry category:term
     *
     * @return mixed
     */
    public function getName();
}