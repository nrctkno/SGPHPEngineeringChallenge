<?php

declare(strict_types=1);

namespace Domain\Product\Port;

use Domain\Product\Product;
use Domain\Product\StyleNumber;
use Domain\Product\SyncStatus;

interface ProductRepository
{

    function createProduct(Product $product, SyncStatus $satus);

    function updateProduct(Product $product);

    function getProduct(StyleNumber $number): ?Product;
}
