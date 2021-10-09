<?php

declare(strict_types=1);

namespace Test\Store\Accounting\Domain\OrderLine;

use Faker\Factory;
use Store\Accounting\Domain\OrderLine\OrderLineUnitPrice;

final class OrderLineUnitPriceMother
{
    public static function create(float $orderLineQuantity): OrderLineUnitPrice
    {
        return new OrderLineUnitPrice($orderLineQuantity);
    }

    public static function random(): OrderLineUnitPrice
    {
        return self::create(Factory::create()->randomFloat(2,10, 100));
    }
}
