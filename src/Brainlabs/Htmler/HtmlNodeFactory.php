<?php

namespace Brainlabs\Htmler;

use Exception;

use Brainlabs\Htmler\NestingBehaviours\NestingNodeBehaviour;
use Brainlabs\Htmler\NestingBehaviours\VoidNodeBehaviour;

class HtmlNodeFactory
{
    private $nestingTags;
    private $voidTags;

    public function __construct(array $nestingTags, array $voidTags)
    {
        $this->nestingTags = $nestingTags;
        $this->voidTags = $voidTags;
    }

    public static function fromFile(string $filePath): HtmlNodeFactory
    {
        $fileContents = @file_get_contents($filePath);
        if ($fileContents === false) {
            throw new Exception("File {$filePath} not found.");
        }
        $json = json_decode($fileContents, true);
        if ($json === null) {
            throw new Exception("Unable to parse file as json.");
        }
        if (array_key_exists("nesting", $json)) {
            $nestingTags = $json['nesting'];
        } else {
            throw new Exception(
                "There was no array labeled 'nesting' in the file."
            );
        }
        if (array_key_exists("void", $json)) {
            $voidTags = $json['void'];
        } else {
            throw new Exception(
                "There was no array labeled 'void' in the file."
            );
        }
        return new self($nestingTags, $voidTags);
    }

    public function makeHtmlNode(string $tag): HtmlNode
    {
        $isNesting = in_array($tag, $this->nestingTags);
        $isVoid = in_array($tag, $this->voidTags);
        
        if ($isNesting && $isVoid) {
            throw new Exception("'{$tag}' is listed as both void and nesting");
        }
        if ($isNesting) {
            return new HtmlNode($tag, new NestingNodeBehaviour());
        }
        if ($isVoid) {
            return new HtmlNode($tag, new VoidNodeBehaviour());
        }
        throw new Exception("'{$tag}' is not a registered HTML tag");
    }
}
