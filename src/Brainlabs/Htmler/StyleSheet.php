<?php

namespace Brainlabs\Htmler;

use Exception;

class StyleSheet
{
    private $css;

    private function __construct(string $css)
    {
        $this->css = $css;
    }

    public static function fromFile(string $filePath): StyleSheet
    {
        $content = @file_get_contents($filePath);

        if ($content === false) {
            throw new Exception("File not found.");
        }

        return new self($content);
    }

    public static function standard(string $name): StyleSheet
    {
        $path = __DIR__ . "/StyleSheets/$name.css";

        try {
            return self::fromFile($path);
        } catch (Exception $e) {
            throw new Exception("No standard stylesheet with name \"$name\".");
        }
    }

    public function getCss(): string
    {
        return $this->css;
    }

    public function cascade(StyleSheet $styleSheet): Stylesheet
    {
        $css = $this->css . $styleSheet->getCss();
        
        return new self($css);
    }
}
