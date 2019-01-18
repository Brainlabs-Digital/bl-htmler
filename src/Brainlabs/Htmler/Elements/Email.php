<?php

namespace Brainlabs\Htmler\Elements;

use Brainlabs\Htmler\Element;
use Brainlabs\Htmler\HasChildren;
use Brainlabs\Htmler\ElementVisitor;
use Brainlabs\Htmler\NodeProperties;

class Email implements Element, HasChildren
{
    private $children = [];
    private $nodeProperties;
    private $subject;
    
    public function __construct(string $subject)
    {
        $this->nodeProperties = new NodeProperties();
        $this->subject = $subject;
    }

    public function accept(ElementVisitor $visitor): void
    {
        $visitor->visitEmail($this);
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

    public function getSubject(): string
    {
        return $this->subject;
    }
}
