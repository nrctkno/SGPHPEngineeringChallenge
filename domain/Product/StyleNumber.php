<?php

declare(strict_types=1);

namespace Domain\Product;

use Domain\Common\DomainException;

class StyleNumber
{

    private string $id;

    function __construct(string $id)
    {
        if (!preg_match('/^([A-Z]{3})([|]{1})([0-9]{3})$/i', $id)) {
            throw new DomainException('Invalid style number format: ' . $id);
        }
        $this->id = $id;
    }

    function get(): string
    {
        return $this->id;
    }

    function __toString(): string
    {
        return $this->id;
    }
}
