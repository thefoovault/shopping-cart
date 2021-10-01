<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Domain\Cart;

use Faker\Factory;
use ShoppingCart\Domain\Cart\CartTotalAmount;

final class CartTotalAmountMother
{
    public static function create(float $cartTotalAmount): CartTotalAmount
    {
        return new CartTotalAmount($cartTotalAmount);
    }

    public static function random(): CartTotalAmount
    {
        return self::create(Factory::create()->randomFloat(2,10, 100));
    }
}
