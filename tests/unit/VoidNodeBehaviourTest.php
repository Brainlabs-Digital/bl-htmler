<?php

namespace Brainlabs\Htmler\Test;

use PHPUnit\Framework\TestCase;
use Exception;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\NestingBehaviours\VoidNodeBehaviour;

class VoidNodeBehaviourTest extends TestCase
{
    public function testAddChildThrowsException()
    {
        $behaviour = new VoidNodeBehaviour();
        $this->expectException(Exception::class);
        $behaviour->addChild(new HtmlNode("br", new VoidNodeBehaviour()));
    }

    public function testSetTextThrowsException()
    {
        $behaviour = new VoidNodeBehaviour();
        $this->expectException(Exception::class);
        $behaviour->setText("something");
    }
}
