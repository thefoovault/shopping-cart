<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Domain\Cart;

use Faker\Factory;
use Store\ShoppingCart\Domain\Cart\CartId;

final class CartIdMother
{
    public static function create(string $cartId): CartId
    {
        return new CartId($cartId);
    }

    public static function random(): CartId
    {
        return self::create(Factory::create()->uuid());
    }
}
