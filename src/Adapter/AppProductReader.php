<?php

namespace App\Adapter;

use App\Entity\Product as EntityProduct;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Product\Port\ProductReader;

class AppProductReader implements ProductReader
{

    private EntityManager $em;


    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    function getImportedProducts(): array
    {
        return $this->em
            ->getRepository(EntityProduct::class)
            ->findBy([
                'status' => 'i'
            ]);
    }
}
