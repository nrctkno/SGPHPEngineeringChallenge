<?php

use Domain\Common\DomainException;
use Domain\Product\Price;
use Domain\Product\StyleNumber;
use Domain\Product\SyncStatus;
use PHPUnit\Framework\TestCase;

class PriceModelConstraintsOnCreationTest extends TestCase
{

    public function testInvalidPricesThrowException()
    {
        $this->expectException(DomainException::class);

        new Price(-1, 'USD');
        new Price(10, 'USDX');
        new Price(10, '');
    }

    public function testValidPriceIsCreated()
    {
        try {
            new Price(100, 'EUR');
        } catch (\Exception $notExpected) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}
