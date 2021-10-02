<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Domain\Cart;

use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartLines;
use ShoppingCart\Domain\Cart\CartTotalAmount;

final class CartMother
{
    public static function create(
        CartId $cartId,
        CartLines $cartLines
    ): Cart
    {
        return new Cart(
            $cartId,
            $cartLines
        );
    }

    public static function random(): Cart
    {
        return self::create(
            CartIdMother::random(),
            CartLinesMother::random()
        );
    }

    public static function randomEmptyCart(): Cart
    {
        return self::create(
            CartIdMother::random(),
            CartLinesMother::create([])
        );
    }

    public static function fullCart(): Cart
    {
        return self::create(
            CartIdMother::random(),
            CartLinesMother::fullCartLines()
        );
    }
}
