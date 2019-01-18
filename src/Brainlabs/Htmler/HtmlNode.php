<?php

namespace Brainlabs\Htmler;

class HtmlNode
{
    private $tag;
    private $attributes = [];
    private $nestingBehaviour;
    
    public function __construct(
        string $tag,
        NestingBehaviour $nestingBehaviour
    ) {
        $this->tag = $tag;
        $this->nestingBehaviour = $nestingBehaviour;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttribute(string $name, string $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function unsetAttribute(string $name): void
    {
        unset($this->attributes[$name]);
    }

    public function setText(string $text): void
    {
        $this->nestingBehaviour->setText($text);
    }

    public function addChild(HtmlNode $child): void
    {
        $this->nestingBehaviour->addChild($child);
    }

    public function asHtml(): string
    {
        return $this->nestingBehaviour->toHtml($this);
    }
}
