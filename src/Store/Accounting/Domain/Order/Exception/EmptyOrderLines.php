<?php

declare(strict_types=1);

namespace Store\Accounting\Domain\Order\Exception;

use Shared\Domain\Exception\DomainError;

final class EmptyOrderLines extends DomainError
{
    public function errorCode(): string
    {
        return 'order_empty_lines';
    }

    public function errorMessage(): string
    {
        return 'Cannot create order with empty lines';
    }
}
