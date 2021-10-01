<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Domain\Product;

use ShoppingCart\Domain\Product\Product;
use ShoppingCart\Domain\Product\ProductId;
use ShoppingCart\Domain\Product\ProductName;
use ShoppingCart\Domain\Product\ProductPrice;

final class ProductMother
{
    public static function create(
        ProductId $productId,
        ProductName $productName,
        ProductPrice $productPrice
    ): Product
    {
        return new Product(
            $productId,
            $productName,
            $productPrice
        );
    }

    public static function random(): Product
    {
        return self::create(
            ProductIdMother::random(),
            ProductNameMother::random(),
            ProductPriceMother::random()
        );
    }
}
