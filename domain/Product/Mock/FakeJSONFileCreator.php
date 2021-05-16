<?php

declare(strict_types=1);

namespace Domain\Product\Mock;

use Domain\Product\Price;
use Domain\Product\Product;
use Domain\Product\Serializer\ProductJsonSerializer;
use Domain\Product\StyleNumber;

class FakeJSONFileCreator
{

    private static $products = ['T-shirt', 'Trainers', 'SmartWatch', 'Jacket', 'Shoes', 'Socks', 'Sweater', 'Coat', 'Shorts', 'Tracksuit', 'Skirt', 'Blouse'];
    private static $brands = ['Nike', 'Adidas', 'New Balance', 'Athix', 'Converse'];
    private static $currencies = ['USD', 'EUR'];

    static function create(string $path, int $records)
    {
        $products = [];
        for ($i = 0; $i < $records; $i++) {

            $products[] = new ProductJsonSerializer(
                new Product(
                    self::styleNumber(),
                    self::name(),
                    self::price(),
                    self::images()
                )
            );
        }

        file_put_contents($path, json_encode($products));
    }

    private static function styleNumber(): StyleNumber
    {
        return new StyleNumber(
            substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3)
                . '|'
                . str_pad(strval(random_int(0, 999)), 3, '0')
        );
    }

    private static function name(): string
    {
        return self::pickOne(self::$products) . ' ' . self::pickOne(self::$brands);
    }

    private static function price(): Price
    {
        return new Price(
            random_int(50, 500),
            self::pickOne(self::$currencies)
        );
    }

    private static function images(): array
    {
        $images = [];
        $qty = random_int(0, 4);

        for ($i  = 0; $i <= $qty; $i++) {
            $images[] = 'https://via.placeholder.com/400x300/4b0082?id=' . $i;
        }

        return $images;
    }

    private static function pickOne($source): string
    {
        $key = array_rand($source, 1);
        return $source[$key];
    }
}
