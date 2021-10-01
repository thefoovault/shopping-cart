<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Domain\Cart;

use Faker\Factory;
use ShoppingCart\Domain\Cart\CartLines;
use Test\ShoppingCart\Domain\CartLine\CartLineMother;

final class CartLinesMother
{
    public static function create(array $cartLines): CartLines
    {
        return new CartLines($cartLines);
    }

    public static function random(): CartLines
    {
        $randomLines = [];
        $numLines = Factory::create()->biasedNumberBetween(2, 10);
        for($i = 0; $i <= $numLines; $i++) {
            $randomLines[] = CartLineMother::random();
        }

        return self::create($randomLines);
    }
}
