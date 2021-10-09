<?php

declare(strict_types=1);

namespace Test\Store\Accounting\Domain\OrderLine;

use Faker\Factory;
use Store\Accounting\Domain\OrderLine\OrderLineQuantity;

final class OrderLineQuantityMother
{
    public static function create(int $orderLineQuantity): OrderLineQuantity
    {
        return new OrderLineQuantity($orderLineQuantity);
    }

    public static function random(): OrderLineQuantity
    {
        return self::create(Factory::create()->numberBetween(1,15));
    }
}
