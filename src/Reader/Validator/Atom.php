<?php

namespace Ahoraian\Feed\Reader\Validator;

use Ahoraian\Feed\Reader\Exception\ValidatorException;

class Atom extends AbstractValidatorInterface
{
    /**
     * Validate a document for some elements exist
     */
    public function validate()
    {
        $domElement = $this->dom->documentElement;

        // validate Feed nodes
        $domFeedNodes = [];
        foreach ($domElement->childNodes as $node) {
            $domFeedNodes[$node->nodeName] = $node->nodeValue;
        }
        foreach ($this->nodes['feed'] as $nodeName) {
            if (!array_key_exists($nodeName, $domFeedNodes)) {
                throw new ValidatorException("feed.{$nodeName} is not exist");
            }
        }

        // check Entry required nodes exist
        $domEntryNodes = [];
        $items = $this->dom->getElementsByTagName('entry');
        foreach ($items->item(0)->childNodes as $node) {
            $domEntryNodes[$node->nodeName] = $node->nodeValue;
        }
        foreach ($this->nodes['entry'] as $nodeName) {
            if (!array_key_exists($nodeName, $domEntryNodes)) {
                throw new ValidatorException("feed.entry.{$nodeName} is not exist");
            }
        }
    }
}