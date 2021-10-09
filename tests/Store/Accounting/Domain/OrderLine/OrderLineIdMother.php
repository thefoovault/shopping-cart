<?php

declare(strict_types=1);

namespace Test\Store\Accounting\Domain\OrderLine;

use Faker\Factory;
use Store\Accounting\Domain\OrderLine\OrderLineId;

final class OrderLineIdMother
{
    public static function create(string $orderLineId): OrderLineId
    {
        return new OrderLineId($orderLineId);
    }

    public static function random(): OrderLineId
    {
        return self::create(Factory::create()->uuid());
    }
}
