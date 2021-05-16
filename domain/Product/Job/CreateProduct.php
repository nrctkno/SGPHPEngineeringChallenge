<?php

declare(strict_types=1);

namespace Domain\Product\Job;

use Domain\Product\Port\ProductRepository;
use Domain\Product\Product;
use Domain\Product\SyncStatus;

final class CreateProduct
{

    private ProductRepository $repository;

    function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    function __invoke(Product $product)
    {
        $this->repository->createProduct($product, SyncStatus::imported());
    }
}
