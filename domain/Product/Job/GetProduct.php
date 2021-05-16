<?php

declare(strict_types=1);

namespace Domain\Product\Job;

use Domain\Product\Port\ProductRepository;
use Domain\Product\Product;
use Domain\Product\StyleNumber;

final class GetProduct
{

    private ProductRepository $repository;

    function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    function __invoke(StyleNumber $id): ?Product
    {
        return $this->repository->getProduct($id);
    }
}
