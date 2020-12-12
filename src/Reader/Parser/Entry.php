<?php

namespace Ahoraian\Feed\Reader\Parser;

use DateTime;
use Ahoraian\Feed\Reader\EntryInterface;

class Entry implements EntryInterface
{
    /**
     * @var array
     */
    protected $entry;

    /**
     * Entry constructor.
     * @param array $entry
     */
    public function __construct(array $entry)
    {
        $this->entry = $entry;
    }

    /**
     * get node by tab name
     * @param $tag
     * @return mixed
     */
    public function get($tag)
    {
        return isset($this->entry[$tag]) ? $this->entry[$tag] : null;
    }

    public function getId()
    {
        return $this->get('id');
    }

    public function getTitle()
    {
        return $this->get('title');
    }

    public function getSubtitle()
    {
        return $this->get('subtitle');
    }

    public function getLastModification()
    {
        return new DateTime($this->get('updated'));
    }

    public function getAuthors()
    {
        return $this->get('author');
    }

    public function getLinks()
    {
        return $this->get('link');
    }

    public function getCategories()
    {
        $categories = [];
        if ($this->get('category')) {
            foreach ($this->get('category') as $category) {
                $categories[] = new Category($category);
            }
        }

        return count($categories) ? $categories : null;
    }

    public function getSummary()
    {
        return $this->get('summary');
    }

    public function getPublishedDate()
    {
        return $this->get('published') ? new DateTime($this->get('published')) : null;
    }

    public function getCopyright()
    {
        return $this->get('rights');
    }

    public function getContent()
    {
        return $this->get('content');
    }

    public function getContributors()
    {
        return $this->get('contributor');
    }

    public function getSource()
    {
        return $this->get('source');
    }
}