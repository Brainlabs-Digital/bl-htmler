<?php

namespace Brainlabs\Htmler\Test\Elements;

use Exception;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\Elements\Email;
use Brainlabs\Htmler\Elements\Paragraph;
use Brainlabs\Htmler\Renderer;
use Brainlabs\Htmler\ElementToHtmlNodeTransformer;
use Brainlabs\Htmler\HtmlNode;
use Brainlabs\Htmler\HtmlNodeFactory;

class EmailTest extends TestCase
{
    public function testRenderEmptyEmail()
    {
        $email = new Email("subject");

        $renderer = new Renderer();
        $html = $renderer->render($email);

        $this->assertEquals(
            '<html><head><meta http-equiv="Content-Type" '
            .'content="text/html; charset=utf-8"><meta name="viewport" '
            .'content="width=device-width, initial-scale=1.0">'
            .'<title>subject</title></head><body title="'
            .'This message has '
            .'been inserted into the title attribute which has been inserted '
            .'into the body tag of this html document in order to ensure that '
            .'the body of this email contains enough bytes for it to be '
            .'displayed correctly in certain email apps.  '
            .'Please do not remove this attribute.  '
            .'This message has '
            .'been inserted into the title attribute which has been inserted '
            .'into the body tag of this html document in order to ensure that '
            .'the body of this email contains enough bytes for it to be '
            .'displayed correctly in certain email apps.  '
            .'Please do not remove this attribute.  '
            .'This message has '
            .'been inserted into the title attribute which has been inserted '
            .'into the body tag of this html document in order to ensure that '
            .'the body of this email contains enough bytes for it to be '
            .'displayed correctly in certain email apps.  '
            .'Please do not remove this attribute.  '
            .'This message has '
            .'been inserted into the title attribute which has been inserted '
            .'into the body tag of this html document in order to ensure that '
            .'the body of this email contains enough bytes for it to be '
            .'displayed correctly in certain email apps.  '
            .'Please do not remove this attribute.  '
            .'"></body></html>',
            $html
        );
    }

    public function testRenderLongEmail()
    {
        $email = new Email("subject");
        for ($i = 0; $i < 19; $i++) {
            $email->addChild(
                new Paragraph(
                    "HelloHelloHelloHelloHelloHelloHelloHelloHelloHello"
                )
            );
        }

        $renderer = new Renderer();
        $html = $renderer->render($email);

        $this->assertEquals(
            '<html><head><meta http-equiv="Content-Type" '
            .'content="text/html; charset=utf-8"><meta name="viewport" '
            .'content="width=device-width, initial-scale=1.0">'
            .'<title>subject</title></head><body>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'<p>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</p>'
            .'</body></html>',
            $html
        );
    }

    public function testCanAcceptElementToHtmlNodeTransformer()
    {
        $email = new Email("subject");

        $factory = $this->createMock(HtmlNodeFactory::class);
        $elementToHtmlNodeTransformer = new ElementToHtmlNodeTransformer(
            $factory
        );
        $email->accept($elementToHtmlNodeTransformer);
        $node = $elementToHtmlNodeTransformer->getHtmlNode();

        $this->assertInstanceOf(HtmlNode::class, $node);
    }
}
