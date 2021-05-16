<?php

declare(strict_types=1);

namespace Domain\Product\Job;

use Domain\Product\Port\ProductRepository;
use Domain\Product\Product;
use Domain\Product\SyncStatus;

final class CreateOrUpdateProduct
{

    private ProductRepository $repository;

    function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    function __invoke(Product $product): void
    {
        $existing = $this->repository->getProduct($product->getStyleNumber());

        $product->setStatus(SyncStatus::imported());

        if (is_null($existing)) {
            $this->repository->createProduct($product);
            return;
        }

        if (!$existing->equals($product)) {
            $this->repository->updateProduct($product);
            return;
        }
    }
}
