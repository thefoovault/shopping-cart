<?php

declare(strict_types=1);

namespace Test\Store\Accounting\Domain\Order;

use Faker\Factory;
use Store\Accounting\Domain\Order\OrderId;

final class OrderIdMother
{
    public static function create(string $orderId): OrderId
    {
        return new OrderId($orderId);
    }

    public static function random(): OrderId
    {
        return self::create(Factory::create()->uuid());
    }
}
