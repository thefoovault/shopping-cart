<?php

declare(strict_types=1);

namespace Test\Store\Domain\Product;

use Faker\Factory;
use Store\Domain\Product\ProductPrice;

final class ProductPriceMother
{
    public static function create(float $productPrice): ProductPrice
    {
        return new ProductPrice($productPrice);
    }

    public static function random(): ProductPrice
    {
        return self::create(Factory::create()->randomFloat(2,10, 100));
    }
}
