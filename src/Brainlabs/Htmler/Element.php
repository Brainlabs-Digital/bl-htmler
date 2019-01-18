<?php

namespace Brainlabs\Htmler;

interface Element
{
    public function accept(ElementVisitor $visitor): void;
}
