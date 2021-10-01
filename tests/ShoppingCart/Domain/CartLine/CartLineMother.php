<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Domain\CartLine;

use ShoppingCart\Domain\CartLine\CartLine;
use ShoppingCart\Domain\CartLine\CartLineAmount;
use ShoppingCart\Domain\CartLine\CartLineId;
use ShoppingCart\Domain\CartLine\CartLineQuantity;
use ShoppingCart\Domain\Product\Product;
use Test\ShoppingCart\Domain\Product\ProductMother;

final class CartLineMother
{
    public static function create(
        CartLineId $cartLineId,
        Product $product,
        CartLineQuantity $cartLineQuantity,
        CartLineAmount $cartLineAmount
    ): CartLine
    {
        return new CartLine(
            $cartLineId,
            $product,
            $cartLineQuantity,
            $cartLineAmount
        );
    }

    public static function random(): CartLine
    {
        return self::create(
            CartLineIdMother::random(),
            ProductMother::random(),
            CartLineQuantityMother::random(),
            CartLineAmountMother::random()
        );
    }
}
