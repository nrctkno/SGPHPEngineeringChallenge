<?php

declare(strict_types=1);

namespace Domain\Product\Serializer;

use Domain\Product\Product;
use JsonSerializable;

class ProductJsonSerializer implements JsonSerializable
{

    private Product $product;

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    function jsonSerialize()
    {
        $price = $this->product->getPrice();

        return [
            'styleNumber' => $this->product->getStyleNumber()->__toString(),
            'name' => $this->product->getName(),
            'price' => ['amount' => $price->getAmount(), 'currency' => $price->getCurrency()],
            'images' => $this->product->getImages(),
        ];
    }
}
