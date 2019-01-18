<?php

namespace Brainlabs\Htmler\Elements;

use Exception;

use Brainlabs\Htmler\Element;
use Brainlabs\Htmler\ElementVisitor;
use Brainlabs\Htmler\NodeProperties;

class Table implements Element
{
    private $rows;
    private $headers;
    
    private $nodeProperties;

    public function __construct(array $rows, array $headers = null)
    {
        $this->rows = $rows;
        $this->headers = $headers;

        $this->nodeProperties = new NodeProperties();

        $this->validate();
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @return array|null
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    public function accept(ElementVisitor $visitor): void
    {
        $visitor->visitTable($this);
    }

    public function getNodeProperties(): NodeProperties
    {
        return $this->nodeProperties;
    }

    /**
     * Phan can't tell that `$this->headers` is non-null when checking the
     * headers count, so we suppress the warning.
     *
     * @suppress PhanTypeMismatchArgumentInternal
     */
    private function validate()
    {
        if ($this->rows === []) {
            return;
        }

        $rowSizes = array_map('count', $this->rows);
        if (count(array_unique($rowSizes)) > 1) {
            throw new Exception("Table data must be rectangular.");
        }

        $rowSize = array_shift($rowSizes);
        if (!is_null($this->headers) && (count($this->headers) != $rowSize)) {
            throw new Exception("Number of headers does not match table data.");
        }
    }
}
