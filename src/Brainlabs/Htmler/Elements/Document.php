<?php

namespace Brainlabs\Htmler\Elements;

use Brainlabs\Htmler\Element;
use Brainlabs\Htmler\HasChildren;
use Brainlabs\Htmler\ElementVisitor;
use Brainlabs\Htmler\NodeProperties;

class Document implements Element, HasChildren
{
    private $children = [];
    private $nodeProperties;
    
    public function __construct()
    {
        $this->nodeProperties = new NodeProperties();
    }

    public function accept(ElementVisitor $visitor): void
    {
        $visitor->visitDocument($this);
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChild(Element $child): void
    {
        $this->children[] = $child;
    }

    public function getNodeProperties(): NodeProperties
    {
        return $this->nodeProperties;
    }
}
