<?php

namespace Brainlabs\Htmler\Test;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\NodeProperties;
use Brainlabs\Htmler\NestingBehaviours\NestingNodeBehaviour;

class NodePropertiesTest extends TestCase
{
    public function testCanApplyId(): void
    {
        $blankProperties = new NodeProperties();

        $idProperties = new NodeProperties();
        $idProperties->setId("Hello");

        $node = new HtmlNode('div', new NestingNodeBehaviour());
        $blankProperties->applyTo($node);

        $this->assertEquals(
            '<div></div>',
            $node->asHtml()
        );

        $idProperties->applyTo($node);

        $this->assertEquals(
            '<div id="Hello"></div>',
            $node->asHtml()
        );

        $blankProperties->applyTo($node);

        $this->assertEquals(
            '<div></div>',
            $node->asHtml()
        );
    }

    public function testCanApplyClasses(): void
    {
        $blankProperties = new NodeProperties();

        $classesProperties = new NodeProperties();
        $classesProperties->addClass("Hello");
        $classesProperties->addClass("Hi");

        $node = new HtmlNode('div', new NestingNodeBehaviour());
        $blankProperties->applyTo($node);

        $this->assertEquals(
            '<div></div>',
            $node->asHtml()
        );

        $classesProperties->applyTo($node);

        $this->assertEquals(
            '<div class="Hello Hi"></div>',
            $node->asHtml()
        );

        $blankProperties->applyTo($node);

        $this->assertEquals(
            '<div></div>',
            $node->asHtml()
        );
    }
}
