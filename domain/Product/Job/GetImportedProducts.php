<?php

declare(strict_types=1);

namespace Domain\Product\Job;

use Domain\Product\Port\ProductReader;

final class GetImportedProducts
{

    private ProductReader $reader;

    function __construct(ProductReader $reader)
    {
        $this->reader = $reader;
    }

    function __invoke(): array
    {
        return $this->reader->getImportedProducts();
    }
}
