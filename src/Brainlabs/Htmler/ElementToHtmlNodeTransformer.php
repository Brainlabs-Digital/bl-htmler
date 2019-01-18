<?php

namespace Brainlabs\Htmler;

use Exception;

use Brainlabs\Htmler\Elements\Document;
use Brainlabs\Htmler\Elements\Email;
use Brainlabs\Htmler\Elements\Hyperlink;
use Brainlabs\Htmler\Elements\Paragraph;
use Brainlabs\Htmler\Elements\Table;
use Brainlabs\Htmler\Elements\Div;
use Brainlabs\Htmler\Elements\BulletPoints;

class ElementToHtmlNodeTransformer implements ElementVisitor
{
    private $htmlNode;
    private $htmlNodeFactory;

    public function __construct(HtmlNodeFactory $factory)
    {
        $this->htmlNodeFactory = $factory;
    }

    public function getHtmlNode(): HtmlNode
    {
        return $this->htmlNode;
    }

    public function visitDocument(Document $document): void
    {
        $documentNode = $this->htmlNodeFactory->makeHtmlNode("html");
        $document->getNodeProperties()->applyTo($documentNode);

        $bodyNode = $this->htmlNodeFactory->makeHtmlNode("body");
        foreach ($document->getChildren() as $child) {
            $child->accept($this);
            $childNode = $this->getHtmlNode();
            $bodyNode->addChild($childNode);
        }
        $documentNode->addChild($bodyNode);
        $this->htmlNode = $documentNode;
    }

    public function visitEmail(Email $email): void
    {
        $emailNode = $this->htmlNodeFactory->makeHtmlNode("html");
        $email->getNodeProperties()->applyTo($emailNode);

        $headNode = $this->htmlNodeFactory->makeHtmlNode("head");

        $metaContent = $this->htmlNodeFactory->makeHtmlNode("meta");
        $metaContent->setAttribute("http-equiv", "Content-Type");
        $metaContent->setAttribute("content", "text/html; charset=utf-8");
        $headNode->addChild($metaContent);

        $metaViewport = $this->htmlNodeFactory->makeHtmlNode("meta");
        $metaViewport->setAttribute("name", "viewport");
        $metaViewport
            ->setAttribute("content", "width=device-width, initial-scale=1.0");
        $headNode->addChild($metaViewport);

        $title = $this->htmlNodeFactory->makeHtmlNode("title");
        $title->setText($email->getSubject());
        $headNode->addChild($title);
        
        $emailNode->addChild($headNode);

        $bodyNode = $this->htmlNodeFactory->makeHtmlNode("body");
        foreach ($email->getChildren() as $child) {
            $child->accept($this);
            $childNode = $this->getHtmlNode();
            $bodyNode->addChild($childNode);
        }

        if (strlen($bodyNode->asHtml()) < 1024) {
            $bodyNode->setAttribute(
                "title",
                "This message has been inserted into the title attribute "
                ."which has been inserted into the body tag of this html "
                ."document in order to ensure that the body of this email "
                ."contains enough bytes for it to be displayed correctly in "
                ."certain email apps.  Please do not remove this attribute.  "
                ."This message has been inserted into the title attribute "
                ."which has been inserted into the body tag of this html "
                ."document in order to ensure that the body of this email "
                ."contains enough bytes for it to be displayed correctly in "
                ."certain email apps.  Please do not remove this attribute.  "
                ."This message has been inserted into the title attribute "
                ."which has been inserted into the body tag of this html "
                ."document in order to ensure that the body of this email "
                ."contains enough bytes for it to be displayed correctly in "
                ."certain email apps.  Please do not remove this attribute.  "
                ."This message has been inserted into the title attribute "
                ."which has been inserted into the body tag of this html "
                ."document in order to ensure that the body of this email "
                ."contains enough bytes for it to be displayed correctly in "
                ."certain email apps.  Please do not remove this attribute.  "
            );
        }
                
        $emailNode->addChild($bodyNode);
        $this->htmlNode = $emailNode;
    }

    public function visitHyperlink(Hyperlink $hyperlink): void
    {
        $linkNode = $this->htmlNodeFactory->makeHtmlNode("a");

        $hyperlink->getNodeProperties()->applyTo($linkNode);

        $linkNode->setText($hyperlink->getText());
        $linkNode->setAttribute("href", $hyperlink->getUrl());

        $this->htmlNode = $linkNode;
    }

    public function visitParagraph(Paragraph $paragraph): void
    {
        $paragraphNode = $this->htmlNodeFactory->makeHtmlNode("p");

        $paragraph->getNodeProperties()->applyTo($paragraphNode);
        $paragraphNode->setText($paragraph->getText());

        $this->htmlNode = $paragraphNode;
    }

    public function visitTable(Table $table): void
    {
        $tableNode = $this->htmlNodeFactory->makeHtmlNode("table");

        $table->getNodeProperties()->applyTo($tableNode);

        $headers = $table->getHeaders();
        if (!is_null($headers) && count($headers) > 0) {
            $headersNode = $this->htmlNodeFactory->makeHtmlNode("tr");
            foreach ($headers as $header) {
                $headerNode = $this->htmlNodeFactory->makeHtmlNode("th");
                $headerNode->setText($header);
                $headersNode->addChild($headerNode);
            }
            $tableNode->addChild($headersNode);
        }

        foreach ($table->getRows() as $row) {
            $rowNode = $this->htmlNodeFactory->makeHtmlNode("tr");
            foreach ($row as $cell) {
                $cellString = $this->getStringValue($cell);

                $cellNode = $this->htmlNodeFactory->makeHtmlNode("td");
                $cellNode->setText($cellString);
                $rowNode->addChild($cellNode);
            }
            $tableNode->addChild($rowNode);
        }

        $this->htmlNode = $tableNode;
    }

    public function visitDiv(Div $div): void
    {
        $divNode = $this->htmlNodeFactory->makeHtmlNode("div");

        $div->getNodeProperties()->applyTo($divNode);

        foreach ($div->getChildren() as $child) {
            $child->accept($this);
            $childNode = $this->getHtmlNode();
            $divNode->addChild($childNode);
        }

        $this->htmlNode = $divNode;
    }

    public function visitBulletPoints(BulletPoints $bulletPoints): void
    {
        $ulNode = $this->htmlNodeFactory->makeHtmlNode("ul");

        $bulletPoints->getNodeProperties()->applyTo($ulNode);

        foreach ($bulletPoints->getBulletPoints() as $bulletPoint) {
            $liNode = $this->htmlNodeFactory->makeHtmlNode("li");
            $liNode->setText($bulletPoint);
            $ulNode->addChild($liNode);
        }
        $this->htmlNode = $ulNode;
    }

    private function getStringValue($thing): string
    {
        if (is_string($thing)) {
            return $thing;
        } elseif (is_numeric($thing)) {
            return (string) $thing;
        } elseif (is_object($thing) && ($thing instanceof Element)) {
            $thing->accept($this);
            $node = $this->getHtmlNode();
            return $node->asHtml();
        } else {
            throw new Exception("Contents could not be converted to string");
        }
    }
}
