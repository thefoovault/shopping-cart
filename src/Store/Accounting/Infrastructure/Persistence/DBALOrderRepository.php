<?php

declare(strict_types=1);

namespace Store\Accounting\Infrastructure\Persistence;

use Store\Accounting\Domain\Order\Order;
use Store\Accounting\Domain\Order\OrderRepository;

final class DBALOrderRepository implements OrderRepository
{
    public function save(Order $order): void
    {
        // TODO: Implement save() method.
    }
}
