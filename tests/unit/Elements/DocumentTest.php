<?php

namespace Brainlabs\Htmler\Test\Elements;

use Exception;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\Elements\Document;
use Brainlabs\Htmler\Elements\Paragraph;
use Brainlabs\Htmler\Renderer;
use Brainlabs\Htmler\ElementToHtmlNodeTransformer;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\HtmlNodeFactory;

class DocumentTest extends TestCase
{
    public function testRenderEmptyDocument()
    {
        $document = new Document();

        $renderer = new Renderer();
        $html = $renderer->render($document);

        $this->assertEquals("<html><body></body></html>", $html);
    }

    public function testRenderDocumentWithChildren()
    {
        $p1 = new Paragraph("Hello");
        $p2 = new Paragraph("Bye");

        $document = new Document();
        $document->addChild($p1);
        $document->addChild($p2);

        $renderer = new Renderer();
        $html = $renderer->render($document);

        $this->assertEquals("<html><body><p>Hello</p><p>Bye</p></body></html>", $html);
    }

    public function testCanAcceptElementToHtmlNodeTransformer()
    {
        $document = new Document();

        $factory = $this->createMock(HtmlNodeFactory::class);
        $elementToHtmlNodeTransformer = new ElementToHtmlNodeTransformer(
            $factory
        );
        $document->accept($elementToHtmlNodeTransformer);
        $node = $elementToHtmlNodeTransformer->getHtmlNode();

        $this->assertInstanceOf(HtmlNode::class, $node);
    }
}
