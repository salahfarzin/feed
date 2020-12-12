<?php

namespace Ahoraian\Feed\Reader\Parser;

use DOMNode;
use DateTime;
use DOMNodeList;
use Ahoraian\Feed\Reader\FeedInterface;
use Ahoraian\Feed\Reader\Validator\Atom;

class AtomParser extends AbstractParser implements FeedInterface
{
    /**
     * @inheritdoc
     */
    protected $requiredNodes = [
        'feed' => ['id', 'title', 'updated', 'entry'],
        'entry' => ['id', 'title', 'updated']
    ];

    /**
     * NOdes has some children
     *
     * @var string[]
     */
    protected $nestedNodes = ['author', 'entry', 'contributor'];

    /**
     * Parse Atom body
     */
    protected function parse()
    {
        // validate document
        $this->validate(new Atom($this->dom, $this->requiredNodes));

        $this->nodes = array_merge($this->nodes, $this->getChildren($this->dom->documentElement));

        // handle authors, entries
        foreach ($this->nestedNodes as $tag) {
            $this->nodes[$tag] = [];
            $items = $this->dom->getElementsByTagName($tag);
            for ($i = 0; $i < $items->length; $i++) {
                if (!$items->length) continue;

                $this->nodes[$tag][$i] = $this->getChildren($items->item($i));
            }
        }
    }

    /**
     * Return children
     *
     * @param DOMNode $domNode
     * @return array
     */
    public function getChildren(DOMNode $domNode)
    {
        $nodes = [];
        foreach ($domNode->childNodes as $node) {
            if ($node->nodeName == '#text') continue;

            $nodes[$node->nodeName] = $node->nodeValue;

            // handle attributes
            if (in_array($node->nodeName, ['link', 'summary', 'content', 'category', 'generator'])) {
                $nodes[$node->nodeName] = $this->getAttributes($domNode->getElementsByTagName($node->nodeName), $node->parentNode->nodeName);;
                if (!array_key_exists('value', $nodes[$node->nodeName])) {
                    $nodes[$node->nodeName]['value'] = $node->nodeValue;
                }
            }
        }

        return $nodes;
    }

    /**
     * Return all attributes
     *
     * @param DOMNodeList $nodes
     * @param null $parentNodeName
     * @return array
     */
    public function getAttributes(DOMNodeList $nodes, $parentNodeName = null)
    {
        $attributes = [];
        for ($i = 0; $i < $nodes->length; $i++) {
            if ($parentNodeName && $nodes->item($i)->parentNode->nodeName !== $parentNodeName) continue;
            $props = $nodes->item($i)->attributes;

            // get all attributes
            for ($j = 0; $j < $props->length; $j++) {
                $attr = $props->item($j);
                $attributes[$i][$attr->nodeName] = $attr->nodeValue;
            }
        }

        return $attributes;
    }

    /**
     * Get specific node
     *
     * @param $tag
     * @return mixed
     */
    public function get($tag)
    {
        return isset($this->nodes[$tag]) ? $this->nodes[$tag] : null;
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

        return $categories;
    }

    public function getItems()
    {
        $entries = [];

        foreach ($this->get('entry') as $entry) {
            $entries[] = new Entry($entry);
        }

        return $entries;
    }

    /**
     * return namespace URI
     * @return string
     */
    public function getNamespace()
    {
        return $this->dom->getElementsByTagName('feed')->item(0)->namespaceURI;
    }

    /**
     * return namespace URI
     * @return array
     */
    public function getFeedAttributes()
    {
        $feedNode = $this->dom->getElementsByTagName('feed');
        $attributes = $this->getAttributes($feedNode);

        return array_merge([
            'namespace' => $this->getNamespace(),
            'childCount' => $feedNode->item(0)->childNodes->length
        ], @$attributes[0] ?? []);
    }

    public function getCopyright()
    {
        return $this->get('rights');
    }

    public function getIcon()
    {
        return $this->get('icon');
    }

    public function getLogo()
    {
        return $this->get('logo');
    }

    public function getContributors()
    {
        return $this->get('contributor');
    }

    /**
     * @return array|null
     */
    public function getGenerator()
    {
        return $this->get('generator');
    }

    /**
     * return all nodes in array
     * @return string
     */
    public function getEncode()
    {
        return $this->dom->encoding;
    }

    /**
     * return all nodes in array
     * @return array
     */
    public function all()
    {
        return $this->nodes;
    }
}