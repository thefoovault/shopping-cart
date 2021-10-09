<?php

declare(strict_types=1);

namespace Store\Accounting\Domain\Order;

use Shared\Domain\Aggregate\Collection;
use Store\Accounting\Domain\OrderLine\OrderLine;

final class OrderLines extends Collection
{
    protected function type(): string
    {
        return OrderLine::class;
    }
}
