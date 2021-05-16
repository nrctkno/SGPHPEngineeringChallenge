<?php

declare(strict_types=1);

namespace Domain\Product;

use DomainException;

class Price
{

    private $amount;
    private $currency;

    function __construct(int $amount, string $currency)
    {
        if ($amount < 0) {
            throw new DomainException('Invalid amount: ' . $amount);
        }

        if (!preg_match('/^([A-Z]{3})$/i', $currency)) {
            throw new DomainException('Invalid currency format: ' . $currency);
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    function getAmount()
    {
        return $this->amount;
    }

    function getCurrency()
    {
        return $this->currency;
    }
}
