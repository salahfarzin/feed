<?php

namespace Ahoraian\Feed\Reader\Parser;

use Ahoraian\Feed\Reader\CategoryInterface;

class Category implements CategoryInterface
{
    /**
     * @var array
     */
    protected $category;

    public function __construct(array $category)
    {
        $this->category = $category;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->category['term'];
    }
}