<?php

namespace Brainlabs\Htmler\Test;

use Exception;

use PHPUnit\Framework\TestCase;

use Brainlabs\Htmler\Renderer;
use Brainlabs\Htmler\StyleSheet;

class StyleSheetTest extends TestCase
{
    const PROJECT_DIR = __DIR__ . '/../../';

    /**
     * @dataProvider standardStyleSheetProvider
     */
    public function testStandardStyleSheetConstruction($standard)
    {
        $stylesheet = StyleSheet::standard($standard);

        $this->assertInstanceOf(StyleSheet::class, $stylesheet);
    }

    public function standardStyleSheetProvider()
    {
        return [
            ['Blue' => 'Blue'],
            ['Console' => 'Console']
        ];
    }

    /**
     * @expectedException Exception
     */
    public function testInvalidStyleSheetStandardName()
    {
        $stylesheet = StyleSheet::standard("FakeStyleSheetName");
    }

    /**
     * @dataProvider styleSheetFilePathProvider
     */
    public function testFromFileStyleSheetConstruction($filePath)
    {
        $styleSheet = StyleSheet::fromFile($filePath);

        $this->assertInstanceOf(StyleSheet::class, $styleSheet);
    }

    /**
     * @dataProvider styleSheetFilePathProvider
     */
    public function testGetCss($filePath)
    {
        $styleSheet = StyleSheet::fromFile($filePath);

        $this->assertEquals(
            file_get_contents($filePath),
            $styleSheet->getCss()
        );
    }

    public function styleSheetFilePathProvider()
    {
        $pathToStyleSheets = self::PROJECT_DIR . '/src/Brainlabs/Htmler/StyleSheets/';

        return [
            ['Blue' => $pathToStyleSheets . 'Blue.css'],
            ['Console' => $pathToStyleSheets . 'Console.css']
        ];
    }

    /**
     * @expectedException Exception
     */
    public function testInvalidStyleSheetFilePath()
    {
        $styleSheet = StyleSheet::fromFile('FakeStyleSheet.css');
    }

    public function testCascadeReturnsStyleSheet()
    {
        $testStyleSheets = self::PROJECT_DIR . '/tests/StyleSheets/';
        $pathToTestCss = $testStyleSheets . 'Test.css';
        $pathToCascadeTestCss = $testStyleSheets . 'CascadeTest.css';

        $styleSheet = StyleSheet::fromFile($pathToTestCss);

        $cascadedStyleSheet = $styleSheet->cascade(
            StyleSheet::fromFile($pathToCascadeTestCss)
        );

        $this->assertInstanceOf(StyleSheet::class, $cascadedStyleSheet);
    }

    public function testCascadeReturnsCascadedCss()
    {
        $testStyleSheets = self::PROJECT_DIR . '/tests/StyleSheets/';
        $pathToTestCss = $testStyleSheets . 'Test.css';
        $pathToCascadeTestCss = $testStyleSheets . 'CascadeTest.css';

        $styleSheet = StyleSheet::fromFile($pathToTestCss);

        $cascadedStyleSheet = $styleSheet->cascade(
            StyleSheet::fromFile($pathToCascadeTestCss)
        );

        $testCss = file_get_contents($pathToTestCss);
        $testCss .= file_get_contents($pathToCascadeTestCss);

        $this->assertEquals($testCss, $cascadedStyleSheet->getCss());
    }
}
