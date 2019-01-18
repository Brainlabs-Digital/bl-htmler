<?php

namespace Brainlabs\Htmler\Test\Elements;

use Exception;
use DateTime;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\Elements\Table;
use Brainlabs\Htmler\Elements\Hyperlink;
use Brainlabs\Htmler\Renderer;
use Brainlabs\Htmler\ElementToHtmlNodeTransformer;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\HtmlNodeFactory;

class TableTest extends TestCase
{
    /**
     * @dataProvider tableProvider
     */
    public function testTable($rows, $expectedHtml)
    {
        $table = new Table($rows);

        $renderer = new Renderer();
        $html = $renderer->render($table);

        $this->assertEquals($expectedHtml, $html);
    }

    public function tableProvider()
    {
        return [
            "Blank" => [
                [],
                "<table></table>"
            ],
            "Single cell" => [
                [["Hello"]],
                "<table><tr><td>Hello</td></tr></table>"
            ],
            "Number cell" => [
                [[7]],
                "<table><tr><td>7</td></tr></table>"
            ],
            "Link" => [
                [[new Hyperlink("Link", 'www.example.com')]],
                '<table><tr><td><a href="www.example.com">Link</a></td></tr></table>'
            ]
        ];
    }

    /**
     * @expectedException Exception
     */
    public function testNonRectangleTable()
    {
        $rows = [
            ["a", "b"],
            ["c"]
        ];

        $table = new Table($rows);
    }

    public function testHeaders()
    {
        $headers = ['A', 'B'];
        $rows = [
            ["a", "b"]
        ];

        $table = new Table($rows, $headers);

        $renderer = new Renderer();
        $html = $renderer->render($table);

        $this->assertEquals(
            "<table><tr><th>A</th><th>B</th></tr><tr><td>a</td><td>b</td></tr></table>",
            $html
        );
    }

    /**
     * @expectedException Exception
     */
    public function testTooManyHeadersTable()
    {
        $headers = ['A', 'B', 'C'];
        $rows = [
            ["a", "b"],
            ["c", "d"]
        ];

        $table = new Table($rows, $headers);
    }

    /**
     * @expectedException Exception
     */
    public function testTooFewHeadersTable()
    {
        $headers = ['A'];
        $rows = [
            ["a", "b"],
            ["c", "d"]
        ];

        $table = new Table($rows, $headers);
    }

    public function testCanAcceptElementToHtmlNodeTransformer()
    {
        $table = new Table([["test"]]);

        $factory = $this->createMock(HtmlNodeFactory::class);
        $elementToHtmlNodeTransformer = new ElementToHtmlNodeTransformer(
            $factory
        );
        $table->accept($elementToHtmlNodeTransformer);
        $node = $elementToHtmlNodeTransformer->getHtmlNode();

        $this->assertInstanceOf(HtmlNode::class, $node);
    }

    public function testZeroRowsTable()
    {
        $headers = ['A', 'B'];
        $rows = [];

        $table = new Table($rows, $headers);

        $renderer = new Renderer();
        $html = $renderer->render($table);

        $this->assertEquals(
            "<table><tr><th>A</th><th>B</th></tr></table>",
            $html
        );
    }

    public function testEmptyTable()
    {
        $headers = [];
        $rows = [];

        $table = new Table($rows, $headers);

        $renderer = new Renderer();
        $html = $renderer->render($table);

        $this->assertEquals(
            "<table></table>",
            $html
        );
    }

    public function testCellWithElement()
    {
        $rows = [[new Hyperlink("Hello", "www.example.com")]];

        $table = new Table($rows);

        $renderer = new Renderer();
        $html = $renderer->render($table);

        $this->assertEquals(
            "<table><tr><td><a href=\"www.example.com\">Hello</a></td></tr></table>",
            $html
        );
    }

    public function testCellWithInvalidObject()
    {
        $this->expectException(Exception::class);

        $rows = [[new DateTime("1st Jan 2018")]];

        $table = new Table($rows);

        $renderer = new Renderer();
        $html = $renderer->render($table);
    }
}
