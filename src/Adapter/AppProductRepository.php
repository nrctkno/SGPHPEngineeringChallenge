<?php

namespace App\Adapter;

use App\Entity\Product as EntityProduct;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Product\Port\ProductRepository;
use Domain\Product\Product;
use Domain\Product\StyleNumber;

class AppProductRepository implements ProductRepository
{

    private EntityManager $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createProduct(Product $product): void
    {
        $this->save($product);
    }

    public function updateProduct(Product $product): void
    {
        $this->save($product);
    }

    public function getProduct(StyleNumber $number): ?Product
    {
        $entity = $this->em->getRepository(EntityProduct::class)->find($number->__toString());

        return is_null($entity) ? null : $entity->toDomain();
    }


    private function save(Product $product): void
    {
        $entity = EntityProduct::fromDomain($product);
        $this->em->persist($entity);
        $this->em->flush();
    }
}
