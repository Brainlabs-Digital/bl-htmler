<?php

namespace Brainlabs\Htmler\Test;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\Renderer;
use Brainlabs\Htmler\StyleSheet;
use Brainlabs\Htmler\Elements\Paragraph;
use Brainlabs\Htmler\Elements\Document;

class RendererTest extends TestCase
{
    public function testGetStyleSheet()
    {
        $styleSheet = StyleSheet::standard("Blue");
        
        $renderer = new Renderer();
        
        $renderer->setStyleSheet($styleSheet);
        
        $this->assertEquals($styleSheet, $renderer->getStyleSheet());
    }
    
    public function testRenderParagraphWithStyleSheet()
    {
        $styleSheet = StyleSheet::standard("Blue");
        $renderer = new Renderer($styleSheet);
        $paragraph = new Paragraph("test");
        $html = $renderer->render($paragraph);

        $expectedHtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" '
            . "\"http://www.w3.org/TR/REC-html40/loose.dtd\">\n"
            . '<html><body style="font-family: arial; font-size: 16px;"><p>test</p></body></html>';

        $this->assertEquals(
            $expectedHtml,
            $html
        );
    }

    public function testRenderEmptyDocumentWithStyleSheet()
    {
        $styleSheet = StyleSheet::standard("Blue");
        $renderer = new Renderer($styleSheet);
        $document = new Document();
        $html = $renderer->render($document);

        $expectedHtml = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" '
            . "\"http://www.w3.org/TR/REC-html40/loose.dtd\">\n"
            . '<html><body style="font-family: arial; font-size: 16px;"></body></html>';

        $this->assertEquals(
            $expectedHtml,
            $html
        );
    }
}
