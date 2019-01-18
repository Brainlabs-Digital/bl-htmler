<?php

namespace Brainlabs\Htmler;

class NodeProperties
{
    private $id;
    private $classes = [];

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function addClass(string $class): void
    {
        $this->classes[] = $class;
    }

    public function applyTo(HtmlNode $node): void
    {
        $this->applyId($node);
        $this->applyClasses($node);
    }

    private function applyId(HtmlNode $node): void
    {
        if (!is_null($this->id)) {
            $node->setAttribute("id", $this->id);
        } else {
            $node->unsetAttribute("id");
        }
    }

    private function applyClasses(HtmlNode $node): void
    {
        if (!empty($this->classes)) {
            $node->setAttribute(
                "class",
                implode(" ", $this->classes)
            );
        } else {
            $node->unsetAttribute("class");
        }
    }
}
