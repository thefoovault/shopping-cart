<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Domain\Product;

use Faker\Factory;
use ShoppingCart\Domain\Product\ProductId;

final class ProductIdMother
{
    public static function create(string $productId): ProductId
    {
        return new ProductId($productId);
    }

    public static function random(): ProductId
    {
        return self::create(Factory::create()->uuid());
    }
}
