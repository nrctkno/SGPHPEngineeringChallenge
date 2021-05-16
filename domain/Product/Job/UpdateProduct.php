<?php

declare(strict_types=1);

namespace Domain\Product\Job;

use Domain\Product\Port\ProductRepository;
use Domain\Product\Product;

final class UpdateProduct
{

    private ProductRepository $repository;

    function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    function __invoke(Product $product)
    {
        $this->repository->updateProduct($product);
    }
}
