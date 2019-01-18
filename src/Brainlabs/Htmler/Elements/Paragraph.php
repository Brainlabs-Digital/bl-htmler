<?php

namespace Brainlabs\Htmler\Elements;

use Brainlabs\Htmler\Element;
use Brainlabs\Htmler\ElementVisitor;
use Brainlabs\Htmler\NodeProperties;

class Paragraph implements Element
{
    private $text;
    
    private $nodeProperties;

    public function __construct(string $text)
    {
        $this->text = $text;

        $this->nodeProperties = new NodeProperties();
    }

    public function getText(): string
    {
        return $this->text;
    }
    
    public function accept(ElementVisitor $visitor): void
    {
        $visitor->visitParagraph($this);
    }

    public function getNodeProperties(): NodeProperties
    {
        return $this->nodeProperties;
    }
}
