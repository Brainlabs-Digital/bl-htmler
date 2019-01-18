<?php

namespace Brainlabs\Htmler\Test;

use PHPUnit\Framework\TestCase;
use Exception;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\HtmlNodeFactory;

class HtmlNodeFactoryTest extends TestCase
{
    /**
     * @dataProvider validJsonFiles
     */
    public function testFromFileValidInputs($path)
    {
        $factory = HtmlNodeFactory::fromFile($path);
        
        $node1 = $factory->makeHtmlNode('br');
        $html1 = $node1->asHtml();
        $this->assertEquals("<br>", $html1);
        
        $node2 = $factory->makeHtmlNode('a');
        $html2 = $node2->asHtml();
        $this->assertEquals("<a></a>", $html2);
    }

    public function validJsonFiles()
    {
        return [
            [__DIR__ . "/data/goodjson.json"]
        ];
    }

    /**
     * @dataProvider invalidJsonFiles
     */
    public function testFromFileInvalidInputs($path)
    {
        $this->expectException(Exception::class);
        $factory = HtmlNodeFactory::fromFile($path);
    }

    public function invalidJsonFiles()
    {
        return [
            [__DIR__ . "/data/blah"],
            [__DIR__ . "/data/badjson.json"],
            [__DIR__ . "/data/nonesting.json"],
            [__DIR__ . "/data/novoid.json"]
        ];
    }

    public function testMakeNestingHtmlNode()
    {
        $factory = new HtmlNodeFactory(['a'], []);
        $node = $factory->makeHtmlNode('a');
        $html = $node->asHtml();
        $this->assertEquals("<a></a>", $html);
    }

    public function testMakeVoidHtmlNode()
    {
        $factory = new HtmlNodeFactory([], ['br']);
        $node = $factory->makeHtmlNode('br');
        $html = $node->asHtml();
        $this->assertEquals("<br>", $html);
    }

    public function testNotRegisteredHtmlTag()
    {
        $this->expectException(Exception::class);
        $factory = new HtmlNodeFactory([], []);
        $node = $factory->makeHtmlNode('p');
    }

    public function testTagInVoidAndNestingLists()
    {
        $this->expectException(Exception::class);
        $factory = new HtmlNodeFactory(['a'], ['a']);
        $node = $factory->makeHtmlNode('a');
    }
}
