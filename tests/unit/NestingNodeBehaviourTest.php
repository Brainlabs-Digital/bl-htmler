<?php

namespace Brainlabs\Htmler\Test;

use PHPUnit\Framework\TestCase;
use Exception;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\NestingBehaviours\NestingNodeBehaviour;

class NestingNodeBehaviourTest extends TestCase
{
    private $parentNode;
    private $behaviour;
    
    public function setUp()
    {
        $this->parentNode = new HtmlNode("body", new NestingNodeBehaviour());
        $this->behaviour = new NestingNodeBehaviour();
    }
    
    public function testAddChildThrowsNoException()
    {
        $this->behaviour->addChild(new HtmlNode("p", new NestingNodeBehaviour()));
        $expected = "<body><p></p></body>";
        $actual = $this->behaviour->toHtml($this->parentNode);
        $this->assertEquals($expected, $actual);
    }

    public function testSetTextThrowsNoException()
    {
        $this->behaviour->setText("something");
        $expected = "<body>something</body>";
        $actual = $this->behaviour->toHtml($this->parentNode);
        $this->assertEquals($expected, $actual);
    }
}
