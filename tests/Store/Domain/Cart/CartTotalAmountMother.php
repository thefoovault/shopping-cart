<?php

declare(strict_types=1);

namespace Test\Store\Domain\Cart;

use Faker\Factory;
use Store\Domain\Cart\CartTotalAmount;

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
