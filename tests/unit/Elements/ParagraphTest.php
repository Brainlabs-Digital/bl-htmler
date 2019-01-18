<?php

namespace Brainlabs\Htmler\Test\Elements;

use Exception;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\Elements\Paragraph;
use Brainlabs\Htmler\Renderer;
use Brainlabs\Htmler\ElementToHtmlNodeTransformer;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\HtmlNodeFactory;

class ParagraphTest extends TestCase
{
    /**
     * @dataProvider paragraphProvider
     */
    public function testParagraphBuilding($text, $expectedHtml)
    {
        $paragraph = new Paragraph($text);

        $renderer = new Renderer();
        $html = $renderer->render($paragraph);

        $this->assertEquals($expectedHtml, $html);
    }

    public function paragraphProvider()
    {
        return [
            'Standard' => [
                'Hello',
                '<p>Hello</p>'
            ],
            'Apostrophe' => [
                "It's a trap",
                "<p>It's a trap</p>"
            ],
            'Empty' => [
                '',
                '<p></p>'
            ]
        ];
    }

    /**
     * @dataProvider textProvider
     */
    public function testCanGetText($text)
    {
        $paragraph = new Paragraph($text);

        $this->assertEquals($text, $paragraph->getText());
    }

    public function textProvider()
    {
        return [
            'Standard' => ['test'],
            'Numbers' => ['12345'],
            'Space' => [' '],
            'Empty' => ['']
        ];
    }

    public function testCanAcceptElementToHtmlNodeTransformer()
    {
        $paragraph = new Paragraph("test");

        $factory = $this->createMock(HtmlNodeFactory::class);
        $elementToHtmlNodeTransformer = new ElementToHtmlNodeTransformer(
            $factory
        );
        $paragraph->accept($elementToHtmlNodeTransformer);
        $node = $elementToHtmlNodeTransformer->getHtmlNode();

        $this->assertInstanceOf(HtmlNode::class, $node);
    }
}
