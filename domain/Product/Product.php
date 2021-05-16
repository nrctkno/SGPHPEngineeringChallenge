<?php

declare(strict_types=1);

namespace Domain\Product;

class Product
{

    private StyleNumber $styleNumber;
    private string $name;
    private $price;
    private array $images;

    function __construct(StyleNumber $styleNumber, string $name, Price $price, array $images)
    {
        $this->styleNumber = $styleNumber;
        $this->name = $name;
        $this->price = $price;
        $this->images = $images;
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
}
