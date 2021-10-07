<?php

declare(strict_types=1);

namespace Test\Store\Domain\Product;

use Faker\Factory;
use Store\Domain\Product\ProductName;

final class ProductNameMother
{
    public static function create(string $productName): ProductName
    {
        return new ProductName($productName);
    }

    public static function random(): ProductName
    {
        return self::create(Factory::create()->text(50));
    }
}
