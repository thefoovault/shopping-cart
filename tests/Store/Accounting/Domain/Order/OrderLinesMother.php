<?php

declare(strict_types=1);

namespace Test\Store\Accounting\Domain\Order;

use Faker\Factory;
use Store\Accounting\Domain\Order\OrderLines;
use Test\Store\Accounting\Domain\OrderLine\OrderLineMother;

final class OrderLinesMother
{
    private const MIN_ALLOWED_LINES = 1;
    private const MAX_ALLOWED_LINES = 5;
    public static function create(array $cartLines): OrderLines
    {
        return new OrderLines($cartLines);
    }

    public static function random(): OrderLines
    {
        $randomLines = [];
        $numLines = Factory::create()->numberBetween(self::MIN_ALLOWED_LINES, self::MAX_ALLOWED_LINES);

        for($i = 0; $i < $numLines-1; $i++) {
            $randomLines[] = OrderLineMother::random();
        }

        return self::create($randomLines);
    }
}
