<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Domain\CartLine;

use Faker\Factory;
use Store\ShoppingCart\Domain\CartLine\CartLineId;

final class CartLineIdMother
{
    public static function create(string $cartLineId): CartLineId
    {
        return new CartLineId($cartLineId);
    }

    public static function random(): CartLineId
    {
        return self::create(Factory::create()->uuid());
    }
}
