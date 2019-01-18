<?php

namespace Brainlabs\Htmler\Test\Elements;

use Exception;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\Elements\Div;
use Brainlabs\Htmler\Elements\Paragraph;
use Brainlabs\Htmler\Renderer;
use Brainlabs\Htmler\ElementToHtmlNodeTransformer;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\HtmlNodeFactory;

class DivTest extends TestCase
{
    public function testRenderEmptyDiv()
    {
        $div = new Div();

        $renderer = new Renderer();
        $html = $renderer->render($div);

        $this->assertEquals("<div></div>", $html);
    }

    public function testRenderDivWithChildren()
    {
        $p1 = new Paragraph("Hello");
        $p2 = new Paragraph("Bye");

        $div = new Div();
        $div->addChild($p1);
        $div->addChild($p2);

        $renderer = new Renderer();
        $html = $renderer->render($div);

        $this->assertEquals("<div><p>Hello</p><p>Bye</p></div>", $html);
    }

    public function testCanAcceptElementToHtmlNodeTransformer()
    {
        $div = new Div();

        $factory = $this->createMock(HtmlNodeFactory::class);
        $elementToHtmlNodeTransformer = new ElementToHtmlNodeTransformer(
            $factory
        );
        $div->accept($elementToHtmlNodeTransformer);
        $node = $elementToHtmlNodeTransformer->getHtmlNode();

        $this->assertInstanceOf(HtmlNode::class, $node);
    }
}
