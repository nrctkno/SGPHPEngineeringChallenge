<?php

declare(strict_types=1);

namespace Domain\Product\Port;

interface ProductReader
{

    function getImportedProducts(): array;
}
