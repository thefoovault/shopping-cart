<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Domain\CartLine;

use Store\ShoppingCart\Domain\CartLine\CartLine;
use Store\ShoppingCart\Domain\CartLine\CartLineAmount;
use Store\ShoppingCart\Domain\CartLine\CartLineId;
use Store\ShoppingCart\Domain\CartLine\CartLineQuantity;
use Store\ShoppingCart\Domain\Product\Product;
use Test\Store\ShoppingCart\Domain\Product\ProductMother;

final class CartLineMother
{
    public static function create(
        CartLineId $cartLineId,
        Product $product,
        CartLineQuantity $cartLineQuantity
    ): CartLine
    {
        return new CartLine(
            $cartLineId,
            $product,
            $cartLineQuantity
        );
    }

    public static function random(): CartLine
    {
        return self::create(
            CartLineIdMother::random(),
            ProductMother::random(),
            CartLineQuantityMother::random()
        );
    }
}
