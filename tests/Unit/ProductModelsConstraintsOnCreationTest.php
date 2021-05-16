<?php

use Domain\Common\DomainException;
use Domain\Product\Price;
use Domain\Product\StyleNumber;
use PHPUnit\Framework\TestCase;

class ProductModelsConstraintsOnCreationTest extends TestCase
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

    public function testInvalidStyleNumbersThrowException()
    {
        $this->expectException(DomainException::class);

        new StyleNumber('non-valid id');
        new StyleNumber('ABC123');
        new StyleNumber('       ');
        new StyleNumber('   |   ');
    }

    public function testValidStyleNumberIsCreated()
    {
        try {
            new StyleNumber('ABC|123');
            new StyleNumber('ZDE|657');
        } catch (\Exception $notExpected) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}
