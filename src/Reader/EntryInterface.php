<?php

namespace Ahoraian\Feed\Reader;

interface EntryInterface
{
    /**
     * Get the feed ID
     *
     * @return string
     */
    public function getId();

    /**
     * Get the feed Title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get the feed summary
     *
     * @return array
     */
    public function getSummary();

    /**
     * Get the feed updated
     *
     * @return \DateTime
     */
    public function getLastModification();

    /**
     * Get the feed published date
     *
     * @return null|\DateTime
     */
    public function getPublishedDate();

    /**
     * Get the feed authors
     *
     * @return null|array
     */
    public function getAuthors();

    /**
     * Get the feed links with attributes
     * array of links with attributes
     *
     * @return array
     */
    public function getLinks();

    /**
     * Get the feed category
     *
     * @return null|CategoryInterface[]
     */
    public function getCategories();

    /**
     * Get the feed rights
     *
     * @return null|string
     */
    public function getCopyright();

    /**
     * Get the feed content
     * array of content with attributes
     *
     * @return null|array
     */
    public function getContent();

    /**
     * Get the feed contributor
     *
     * @return null|array
     */
    public function getContributors();

    /**
     * Get the feed source
     *
     * @return null|array
     */
    public function getSource();
}