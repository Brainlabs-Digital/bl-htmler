<?php

namespace Brainlabs\Htmler;

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class Renderer
{
    private $styleSheet;

    public function __construct(StyleSheet $styleSheet = null)
    {
        $this->styleSheet = $styleSheet;
    }

    public function getStyleSheet(): StyleSheet
    {
        return $this->styleSheet;
    }

    public function setStyleSheet(StyleSheet $styleSheet): void
    {
        $this->styleSheet = $styleSheet;
    }

    public function render(Element $element): string
    {
        $elementToHtmlNodeTransformer = new ElementToHtmlNodeTransformer(
            HtmlNodeFactory::fromFile(__DIR__ . "/data/nodeTypes.json")
        );
        
        $element->accept($elementToHtmlNodeTransformer);
        $node = $elementToHtmlNodeTransformer->getHtmlNode();

        $html = $node->asHtml();

        if (!is_null($this->styleSheet)) {
            $cssToInlineStyles = new CssToInlineStyles();

            $html = $cssToInlineStyles->convert(
                $html,
                $this->styleSheet->getCss()
            );
        }

        return $html;
    }
}
