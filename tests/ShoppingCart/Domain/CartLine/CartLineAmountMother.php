<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Domain\CartLine;

use Faker\Factory;
use ShoppingCart\Domain\CartLine\CartLineAmount;

final class CartLineAmountMother
{
    public static function create(float $cartLineAmount): CartLineAmount
    {
        return new CartLineAmount($cartLineAmount);
    }

    public static function random(): CartLineAmount
    {
        return self::create(Factory::create()->randomFloat(2,10, 100));
    }
}
