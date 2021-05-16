<?php

use Domain\Common\DomainException;
use Domain\Product\StyleNumber;
use Domain\Product\SyncStatus;
use PHPUnit\Framework\TestCase;

class StyleNumberModelConstraintsOnCreationTest extends TestCase
{

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
