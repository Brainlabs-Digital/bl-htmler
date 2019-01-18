<?php

namespace Brainlabs\Htmler\Test\Elements;

use Exception;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\Elements\BulletPoints;
use Brainlabs\Htmler\Renderer;
use Brainlabs\Htmler\ElementToHtmlNodeTransformer;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\HtmlNodeFactory;

class BulletPointsTest extends TestCase
{
    /**
     * @dataProvider bulletPointsProvider
     */
    public function testBulletPointsBuilding($bulletPoints, $expectedHtml)
    {
        $bulletPoints = new BulletPoints($bulletPoints);

        $renderer = new Renderer();
        $html = $renderer->render($bulletPoints);

        $this->assertEquals($expectedHtml, $html);
    }

    public function bulletPointsProvider()
    {
        return [
            'Standard' => [
                ['point1', 'point2', 'point3'],
                '<ul><li>point1</li><li>point2</li><li>point3</li></ul>'
            ]
        ];
    }

    /**
     * @dataProvider getBulletPointsProvider
     */
    public function testCanGetBulletPoints($points)
    {
        $bulletPoints = new BulletPoints($points);

        $this->assertEquals($points, $bulletPoints->getBulletPoints());
    }

    public function getBulletPointsProvider()
    {
        return [
            'Words' => [["one", "two", "three"]],
            'Ints' => [[1, 2, 3]],
            'Floats' => [[1.0, 2.0, 3.0]],
            'Zero' => [[0]],
            'Empty' => [[]]
        ];
    }

    public function testCanAcceptElementToHtmlNodeTransformer()
    {
        $bulletPoints = new BulletPoints(["Hello", "www.example.com"]);

        $factory = $this->createMock(HtmlNodeFactory::class);
        $elementToHtmlNodeTransformer = new ElementToHtmlNodeTransformer(
            $factory
        );
        $bulletPoints->accept($elementToHtmlNodeTransformer);
        $node = $elementToHtmlNodeTransformer->getHtmlNode();

        $this->assertInstanceOf(HtmlNode::class, $node);
    }
}
