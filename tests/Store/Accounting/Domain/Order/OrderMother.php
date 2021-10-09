<?php

declare(strict_types=1);

namespace Test\Store\Accounting\Domain\Order;

use Store\Accounting\Domain\Order\Order;
use Store\Accounting\Domain\Order\OrderCreationDate;
use Store\Accounting\Domain\Order\OrderId;
use Store\Accounting\Domain\Order\OrderLines;
use Store\Accounting\Domain\Order\OrderStatus;
use Store\Users\Domain\User\UserId;
use Test\Store\Users\Domain\User\UserIdMother;

final class OrderMother
{
    public static function create(
        OrderId $orderId,
        UserId $userId,
        OrderStatus $orderStatus,
        OrderLines $orderLines,
        OrderCreationDate $orderCreationDate
    ): Order
    {
        return new Order(
            $orderId,
            $userId,
            $orderStatus,
            $orderLines,
            $orderCreationDate
        );
    }

    public static function random(): Order
    {
        return self::create(
            OrderIdMother::random(),
            UserIdMother::random(),
            OrderStatus::createWithPendingStatus(),
            OrderLinesMother::random(),
            OrderCreationDate::now()
        );
    }
}
