<?php

declare(strict_types=1);

namespace Test\Store\Domain\CartLine;

use Store\Domain\CartLine\CartLine;
use Store\Domain\CartLine\CartLineAmount;
use Store\Domain\CartLine\CartLineId;
use Store\Domain\CartLine\CartLineQuantity;
use Store\Domain\Product\Product;
use Test\Store\Domain\Product\ProductMother;

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
