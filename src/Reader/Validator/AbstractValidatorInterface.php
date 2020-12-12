<?php

namespace Ahoraian\Feed\Reader\Validator;

use DOMDocument;
use Ahoraian\Feed\Reader\ValidatorInterface;

abstract class AbstractValidatorInterface implements ValidatorInterface
{
    /**
     * xML DOM
     *
     * @var DOMDocument
     */
    protected $dom;

    /**
     * Required nodes
     *
     * @var DOMDocument
     */
    protected $nodes;

    /**
     * Atom constructor.
     * @param DOMDocument $dom
     * @param array $nodes
     */
    public function __construct(DOMDocument $dom, array $nodes) {
        $this->dom = $dom;
        $this->nodes = $nodes;
    }
}