<?php

namespace Brainlabs\Htmler\NestingBehaviours;

use Exception;

use Brainlabs\Htmler\NestingBehaviour;
use Brainlabs\Htmler\HtmlNode;

class VoidNodeBehaviour implements NestingBehaviour
{
    public function __construct()
    {
    }

    public function addChild(HtmlNode $child): void
    {
        throw new Exception("A void HTML node cannot have children.");
    }

    public function setText(string $text): void
    {
        throw new Exception("A void HTML node cannot contain text.");
    }

    public function toHtml(HtmlNode $node): string
    {
        $attributeFragments = [];
        foreach ($node->getAttributes() as $name => $value) {
            $attributeFragments[] = " $name=\"$value\"";
        }
        $attributesString = implode("", $attributeFragments);

        $html = "<{$node->getTag()}$attributesString>";

        return $html;
    }
}
