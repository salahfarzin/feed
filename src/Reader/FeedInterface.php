<?php

namespace Ahoraian\Feed\Reader;

interface FeedInterface
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
     * Get the feed Subtitle
     *
     * @return null|string
     */
    public function getSubtitle();

    /**
     * Get the feed updated
     *
     * @return \DateTime
     */
    public function getLastModification();

    /**
     * Get the feed authors
     *
     * @return null|array
     */
    public function getAuthors();

    /**
     * Get the feed links with attributes
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
     * Get the feed entries)
     *
     * @return EntryInterface[]
     */
    public function getItems();
}