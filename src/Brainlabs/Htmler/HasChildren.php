<?php

namespace Brainlabs\Htmler;

interface HasChildren
{
    public function getChildren(): array;
    
    public function addChild(Element $child): void;
}
