<?php

declare(strict_types=1);

namespace Domain\Product\Port;

use Domain\Product\Product;
use Domain\Product\StyleNumber;

interface ProductRepository
{

    function createProduct(Product $product);

    function updateProduct(Product $product);

    function getProduct(StyleNumber $number): ?Product;
}
