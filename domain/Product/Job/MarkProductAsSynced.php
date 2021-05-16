<?php

declare(strict_types=1);

namespace Domain\Product\Job;

use Domain\Common\DomainException;
use Domain\Product\Port\ProductRepository;
use Domain\Product\StyleNumber;
use Domain\Product\SyncStatus;

final class MarkProductAsSynced
{

    private ProductRepository $repository;

    function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    function __invoke(StyleNumber $id): void
    {
        $product = $this->repository->getProduct($id);

        if (is_null($product)) {
            throw new DomainException(sprintf('The product %s does not exist.', $id->__toString()));
        }

        $product->setStatus(SyncStatus::synced());

        $this->repository->updateProduct($product);
    }
}
