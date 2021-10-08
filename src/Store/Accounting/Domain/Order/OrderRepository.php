<?php

declare(strict_types=1);

namespace Store\Accounting\Domain\Order;

interface OrderRepository
{
    public function save(Order $order): void;
}
