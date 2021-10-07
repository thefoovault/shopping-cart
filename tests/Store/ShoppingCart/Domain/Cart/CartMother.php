<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Domain\Cart;

use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartLines;
use Store\ShoppingCart\Domain\Cart\CartTotalAmount;

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

    public static function withKey(CartId $cartId): Cart
    {
        return self::create(
            $cartId,
            CartLinesMother::random()
        );
    }
}
