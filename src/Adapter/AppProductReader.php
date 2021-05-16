<?php

namespace App\Adapter;

use Domain\Product\Port\ProductReader;

class AppProductReader implements ProductReader
{

    function getImportedProducts(): array
    {
        return [];
    }
}
