<?php

namespace Ahoraian\Feed\Tests\Reader;

use Ahoraian\Feed\Reader;
use Ahoraian\Feed\Reader\Driver\CurlDriver;
use PHPUnit\Framework\TestCase;

class AtomTest extends TestCase
{
    protected $urls = [
        'https://xkcd.com/atom.xml',
        'https://rss.dw.com/atom/rss-en-all'
    ];

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * Initialize test (Set up)
     */
    protected function setUp(): void
    {
        $this->reader = new Reader(new CurlDriver);
    }

    /**
     * check feed reader for load url
     */
    public function test()
    {
        $reader = null;
        foreach ($this->urls as $url) {
            $reader = $this->reader->load($url);

            // check response is object
            $this->assertIsObject($reader);
        }

        // check response for id
        $this->assertIsString($reader->getId());
    }
}