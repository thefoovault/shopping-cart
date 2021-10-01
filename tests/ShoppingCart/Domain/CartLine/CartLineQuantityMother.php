<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Domain\CartLine;

use Faker\Factory;
use ShoppingCart\Domain\CartLine\CartLineQuantity;

final class CartLineQuantityMother
{
    public static function create(int $cartLineQuantity): CartLineQuantity
    {
        return new CartLineQuantity($cartLineQuantity);
    }

    public static function random(): CartLineQuantity
    {
        return self::create(Factory::create()->biasedNumberBetween(1,15));
    }
}
