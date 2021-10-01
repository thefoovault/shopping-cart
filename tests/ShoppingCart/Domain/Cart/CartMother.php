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
        CartLines $cartLines,
        CartTotalAmount $cartTotalAmount
    ): Cart
    {
        return new Cart(
            $cartId,
            $cartLines,
            $cartTotalAmount
        );
    }

    public static function random(): Cart
    {
        return self::create(
            CartIdMother::random(),
            CartLinesMother::random(),
            CartTotalAmountMother::random()
        );
    }
}
