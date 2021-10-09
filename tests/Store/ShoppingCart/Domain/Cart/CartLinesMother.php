<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Domain\Cart;

use Faker\Factory;
use Store\ShoppingCart\Domain\Cart\CartLines;
use Test\Store\ShoppingCart\Domain\CartLine\CartLineMother;

final class CartLinesMother
{
    private const MIN_ALLOWED_LINES = 1;
    private const MAX_ALLOWED_LINES = 5;
    public static function create(array $cartLines): CartLines
    {
        return new CartLines($cartLines);
    }

    public static function random(): CartLines
    {
        $randomLines = [];
        $numLines = Factory::create()->numberBetween(self::MIN_ALLOWED_LINES, self::MAX_ALLOWED_LINES-1);

        for($i = 0; $i < $numLines; $i++) {
            $randomLines[] = CartLineMother::random();
        }

        return self::create($randomLines);
    }

    public static function fullCartLines(): CartLines
    {
        $randomLines = [];

        for($i = 0; $i < self::MAX_ALLOWED_LINES; $i++) {
            $randomLines[] = CartLineMother::random();
        }

        return self::create($randomLines);
    }
}

