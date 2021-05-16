<?php

namespace App\Message;

class ImportSplittedProductsFile
{
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getFileName(): string
    {
        return $this->filename;
    }
}
