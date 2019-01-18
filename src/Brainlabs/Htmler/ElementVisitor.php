<?php

namespace Brainlabs\Htmler;

use Brainlabs\Htmler\Elements\BulletPoints;
use Brainlabs\Htmler\Elements\Div;
use Brainlabs\Htmler\Elements\Document;
use Brainlabs\Htmler\Elements\Email;
use Brainlabs\Htmler\Elements\Hyperlink;
use Brainlabs\Htmler\Elements\Paragraph;
use Brainlabs\Htmler\Elements\Table;

interface ElementVisitor
{
    public function visitBulletPoints(BulletPoints $bulletPoints): void;
    public function visitDiv(Div $div): void;
    public function visitDocument(Document $document): void;
    public function visitEmail(Email $email): void;
    public function visitHyperlink(Hyperlink $hyperlink): void;
    public function visitParagraph(Paragraph $paragraph): void;
    public function visitTable(Table $table): void;
}
