<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Domain\Product\Price;
use Domain\Product\Product as DomainProduct;
use Domain\Product\StyleNumber;
use Domain\Product\SyncStatus;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=7)
     */
    private $style_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="text")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $status;

    public static function fromDomain(DomainProduct $p): Product
    {
        $entity = new static();

        return $entity->fillFromDomain($p);
    }

    public function fillFromDomain(DomainProduct $p): Product
    {
        $this->setStyleNumber($p->getStyleNumber()->__toString());
        $this->setName($p->getName());
        $this->setCurrency($p->getPrice()->getCurrency());
        $this->setAmount($p->getPrice()->getAmount());
        $this->setImages($p->getImages());
        $this->setStatus($p->getStatus());

        return $this;
    }


    public function toDomain(): DomainProduct
    {
        return new DomainProduct(
            new StyleNumber($this->style_number),
            $this->name,
            new Price($this->amount, $this->currency),
            $this->getImages(),
            new SyncStatus($this->status)
        );
    }


    public function getStyleNumber(): string
    {
        return $this->style_number;
    }

    public function setStyleNumber(string $style_number): void
    {
        $this->style_number = $style_number;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getImages(): array
    {
        return json_decode($this->images);
    }

    public function setImages(array $images): void
    {
        $this->images = json_encode($images);
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
