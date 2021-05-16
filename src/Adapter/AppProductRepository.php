<?php

namespace App\Adapter;

use Domain\Product\Port\ProductRepository;
use Domain\Product\Product;
use Domain\Product\StyleNumber;

class AppProductRepository implements ProductRepository
{

    function createProduct(Product $product)
    {
        echo 'create ' . $product->getStyleNumber() . ' ';
    }

    function updateProduct(Product $product)
    {
        echo 'update ' . $product->getStyleNumber() . ' ';
    }

    function getProduct(StyleNumber $number): ?Product
    {
        return null;
    }
}
