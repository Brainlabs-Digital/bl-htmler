<?php

namespace Brainlabs\Htmler\NestingBehaviours;

use Brainlabs\Htmler\NestingBehaviour;
use Brainlabs\Htmler\HtmlNode;

class NestingNodeBehaviour implements NestingBehaviour
{
    private $children = [];
    private $text;
    
    public function addChild(HtmlNode $child): void
    {
        $this->children[] = $child;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function toHtml(HtmlNode $node): string
    {
        $attributeFragments = [];
        foreach ($node->getAttributes() as $name => $value) {
            $attributeFragments[] = " $name=\"$value\"";
        }
        $attributesString = implode("", $attributeFragments);

        $html = "<{$node->getTag()}$attributesString>";
        if (!is_null($this->text)) {
            $html .= $this->text;
        }
        foreach ($this->children as $child) {
            $html .= $child->asHtml();
        }

        $html .= "</{$node->getTag()}>";
        return $html;
    }
}
