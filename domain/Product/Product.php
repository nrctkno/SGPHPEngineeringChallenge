<?php

declare(strict_types=1);

namespace Domain\Product;

class Product
{

    private StyleNumber $styleNumber;
    private string $name;
    private $price;
    private array $images;
    private SyncStatus $status;

    function __construct(
        StyleNumber $styleNumber,
        string $name,
        Price $price,
        array $images,
        SyncStatus $status
    ) {
        $this->styleNumber = $styleNumber;
        $this->name = $name;
        $this->price = $price;
        $this->images = $images;
        $this->status = $status;
    }


    function getStyleNumber(): StyleNumber
    {
        return $this->styleNumber;
    }

    function getName(): string
    {
        return $this->name;
    }

    function getPrice(): Price
    {
        return $this->price;
    }

    function getImages(): array
    {
        return $this->images;
    }

    function getStatus(): SyncStatus
    {
        return $this->status;
    }

    function setStatus(SyncStatus $status): void
    {
        $this->status = $status;
    }


    function equals(Product $other): bool
    {
        return $this->getStyleNumber() == $other->getStyleNumber()
            &&  $this->getName() == $other->getName()
            &&  $this->getPrice() == $other->getPrice()
            &&  $this->getImages() == $other->getImages();
    }
}
