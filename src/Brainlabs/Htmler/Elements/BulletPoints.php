<?php

namespace Brainlabs\Htmler\Elements;

use Brainlabs\Htmler\Element;
use Brainlabs\Htmler\ElementVisitor;
use Brainlabs\Htmler\NodeProperties;

class BulletPoints implements Element
{
    private $bulletPoints;
    
    private $nodeProperties;

    public function __construct(array $bulletPoints)
    {
        $this->bulletPoints = $bulletPoints;

        $this->nodeProperties = new NodeProperties();
    }

    public function getBulletPoints(): array
    {
        return $this->bulletPoints;
    }
    
    public function accept(ElementVisitor $visitor): void
    {
        $visitor->visitBulletPoints($this);
    }

    public function getNodeProperties(): NodeProperties
    {
        return $this->nodeProperties;
    }
}
