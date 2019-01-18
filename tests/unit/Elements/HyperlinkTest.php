<?php

namespace Brainlabs\Htmler\Test\Elements;

use Exception;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\Elements\Hyperlink;
use Brainlabs\Htmler\Renderer;
use Brainlabs\Htmler\ElementToHtmlNodeTransformer;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\HtmlNodeFactory;

class HyperlinkTest extends TestCase
{
    /**
     * @dataProvider hyperlinkProvider
     */
    public function testHyperlink($text, $url, $expectedHtml)
    {
        $link = new Hyperlink($text, $url);

        $renderer = new Renderer();
        $html = $renderer->render($link);

        $this->assertEquals($expectedHtml, $html);
    }

    public function hyperlinkProvider()
    {
        return [
            'Standard' => [
                "Hello",
                "www.example.com",
                '<a href="www.example.com">Hello</a>'
            ],
            'Apostrophe' => [
                "Something's up",
                "www.example.com",
                '<a href="www.example.com">Something\'s up</a>'
            ],
        ];
    }

    /**
     * @dataProvider textProvider
     */
    public function testCanGetText($text)
    {
        $link = new Hyperlink($text, "www.example.com");

        $linkText = $link->getText();

        $this->assertEquals($text, $linkText);
    }

    public function textProvider()
    {
        return [
            'Standard' => ['Hello'],
            'Apostrophe' => ["It's"]
        ];
    }

    /**
     * @dataProvider urlProvider
     */
    public function testCanGetUrl($url)
    {
        $link = new Hyperlink("text", $url);

        $linkUrl = $link->getUrl();

        $this->assertEquals($url, $linkUrl);
    }

    public function urlProvider()
    {
        return [
            'Standard' => ['www.example.com'],
            'Hyphenated' => ['www.hy-phen.com']
        ];
    }

    public function testCanAcceptElementToHtmlNodeTransformer()
    {
        $link = new Hyperlink("Hello", "www.example.com");

        $factory = $this->createMock(HtmlNodeFactory::class);
        $elementToHtmlNodeTransformer = new ElementToHtmlNodeTransformer(
            $factory
        );
        $link->accept($elementToHtmlNodeTransformer);
        $node = $elementToHtmlNodeTransformer->getHtmlNode();

        $this->assertInstanceOf(HtmlNode::class, $node);
    }
}
