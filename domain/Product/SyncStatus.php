<?php

declare(strict_types=1);

namespace Domain\Product;

use DomainException;

class SyncStatus
{

    private string $id;

    static function imported()
    {
        return new static('i');
    }

    static function synced()
    {
        return new static('s');
    }

    static function undefined()
    {
        return new static('u');
    }

    function __construct(string $id)
    {
        if ((strlen($id) !== 1) || !str_contains('isu', $id)) {
            throw new DomainException('Invalid sync status: ' . $id);
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
