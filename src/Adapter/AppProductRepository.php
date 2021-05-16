<?php

namespace App\Adapter;

use App\Entity\Product as EntityProduct;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Product\Port\ProductRepository;
use Domain\Product\Product;
use Domain\Product\StyleNumber;
use Exception;

class AppProductRepository implements ProductRepository
{

    private EntityManager $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createProduct(Product $product): void
    {
        $entity = EntityProduct::fromDomain($product);
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function updateProduct(Product $product): void
    {
        $entity = $this->getEntity($product->getStyleNumber()->__toString());

        if (is_null($entity)) {
            throw new Exception('Entity does not exist.');
        }

        $entity->fillFromDomain($product);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function getProduct(StyleNumber $number): ?Product
    {
        $entity = $this->getEntity($number->__toString());

        return is_null($entity) ? null : $entity->toDomain();
    }

    private function getEntity(string $id): ?EntityProduct
    {
        return $this->em->getRepository(EntityProduct::class)->find($id);
    }
}
