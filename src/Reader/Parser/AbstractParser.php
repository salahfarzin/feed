<?php

namespace Ahoraian\Feed\Reader\Parser;

use DOMDocument;
use Ahoraian\Feed\Reader\Validator\AbstractValidatorInterface;
use Ahoraian\Feed\Reader\Validator\Atom;
use Ahoraian\Feed\Reader\ValidatorInterface;

abstract class AbstractParser
{
    /**
     * XML document
     * @var DOMDocument
     */
    protected $dom;

    /**
     * XML nodes
     * @var array
     */
    protected $nodes = [];

    /**
     * The Feed required nodes
     * @var array
     */
    protected $requiredNodes = [];

    /**
     * AbstractParser constructor.
     * @param DOMDocument $dom
     */
    public function __construct(DOMDocument $dom)
    {
        $this->dom = $dom;

        $this->parse();
    }

    /**
     * Get DOM
     */
    public function getDom()
    {
        return $this->dom;
    }

    /**
     * Validate a document for required nodes
     * @param ValidatorInterface $validator
     * @return mixed
     */
    protected function validate(ValidatorInterface $validator)
    {
        return $validator->validate();
    }

    /**
     * Parse XML body
     */
    abstract protected function parse();
}