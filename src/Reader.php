<?php

namespace Ahoraian\Feed;

use DateTime;
use DOMDocument;
use Ahoraian\Feed\Reader\Parser\AtomParser;
use Ahoraian\Feed\Reader\Driver\Response;
use Ahoraian\Feed\Reader\Driver\HttpDriverInterface;
use Ahoraian\Feed\Reader\Exception\RuntimeException;
use Ahoraian\Feed\Reader\Exception\InvalidArgumentException;
use Ahoraian\Feed\Reader\Exception\NotModifiedResponseException;

class Reader implements ReaderInterface
{
    /**
     * HTTP client object to use for retrieving remote feeds
     *
     * @var HttpDriverInterface
     */
    protected $driver = null;

    /**
     * Parser extensions
     * @var string[]
     */
    protected $parsers = [
        'atom' => AtomParser::class
    ];

    /**
     * Reader constructor.
     * @param HttpDriverInterface $driver
     */
    public function __construct(HttpDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Load a feed by providing a URI
     *
     * @param $uri
     * @param $lastModifiedDate
     * @return mixed
     */
    public function load($uri, DateTime $lastModifiedDate = null)
    {
        $response = $this->driver->getResponse($uri, $lastModifiedDate);

        if (!$response instanceof Response) {
            throw new RuntimeException(sprintf(
                'Did not receive a %s\Driver\ResponseInterface from the provided HTTP client; received "%s"',
                __NAMESPACE__,
                (is_object($response) ? get_class($response) : gettype($response))
            ));
        }

        // not modified
        if ((int)$response->getStatusCode() === 304) {
            throw new NotModifiedResponseException(sprintf(
                'Feed not modified, got response code %s', $response->getStatusCode()
            ) );
        }

        // failed to load url
        if ((int)$response->getStatusCode() !== 200) {
            throw new RuntimeException(sprintf(
                'Feed failed to load, got response code %s', $response->getStatusCode()
            ));
        }

        return $this->parse($response->getBody());
    }

    /**
     * parse XML string
     *
     * @param string $body
     * @return AtomParser
     */
    public function parse(string $body)
    {
        $dom = new DOMDocument();
        $status = $dom->loadXML(trim($body));

        // check the xml document is valid
        $error = 'Invalid XML, DOCTYPE is invalid';
        if (!$status) {
            throw new InvalidArgumentException($error);
        }

        foreach ($dom->childNodes as $child) {
            if ($child->nodeType === XML_DOCUMENT_TYPE_NODE) {
                throw new InvalidArgumentException($error);
            }
        }

        $feed = $dom->getElementsByTagName("feed");
        if(!$feed->length) {
            throw new InvalidArgumentException('Currently this document not supported');
        }

        return new $this->parsers['atom']($dom);
    }

    /**
     * @return HttpDriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }
}