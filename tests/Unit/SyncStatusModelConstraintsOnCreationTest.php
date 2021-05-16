<?php

use Domain\Common\DomainException;
use Domain\Product\SyncStatus;
use PHPUnit\Framework\TestCase;

class SyncStatusModelConstraintsOnCreationTest extends TestCase
{

    public function testInvalidSyncStatusesThrowException()
    {
        $this->expectException(DomainException::class);

        new SyncStatus('');
        new SyncStatus('x');
        new SyncStatus('a');
        new SyncStatus('ax');
        new SyncStatus('is');
        new SyncStatus('su');
        new SyncStatus('isu');
    }

    public function testValidSyncStatusesAreCreated()
    {
        try {
            new SyncStatus('u');
            new SyncStatus('i');
            new SyncStatus('s');
        } catch (\Exception $notExpected) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}
