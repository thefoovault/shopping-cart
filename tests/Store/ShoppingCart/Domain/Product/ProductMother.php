<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Domain\Product;

use Store\ShoppingCart\Domain\Product\Product;
use Store\ShoppingCart\Domain\Product\ProductId;
use Store\ShoppingCart\Domain\Product\ProductName;
use Store\ShoppingCart\Domain\Product\ProductPrice;

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
