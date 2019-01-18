<?php

namespace Brainlabs\Htmler;

interface NestingBehaviour
{
    public function addChild(HtmlNode $child): void;

    public function setText(string $text): void;

    public function toHtml(HtmlNode $node): string;
}
