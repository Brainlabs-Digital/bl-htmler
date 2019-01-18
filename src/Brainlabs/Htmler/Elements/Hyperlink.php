<?php

namespace Brainlabs\Htmler\Elements;

use Brainlabs\Htmler\Element;
use Brainlabs\Htmler\ElementVisitor;
use Brainlabs\Htmler\NodeProperties;

class Hyperlink implements Element
{
    private $text;
    private $url;
    
    private $nodeProperties;

    public function __construct(string $text, string $url)
    {
        $this->text = $text;
        $this->url = $url;

        $this->nodeProperties = new NodeProperties();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
    
    public function accept(ElementVisitor $visitor): void
    {
        $visitor->visitHyperlink($this);
    }

    public function getNodeProperties(): NodeProperties
    {
        return $this->nodeProperties;
    }
}
