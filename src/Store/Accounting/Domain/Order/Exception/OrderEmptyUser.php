<?php

declare(strict_types=1);

namespace Store\Accounting\Domain\Order\Exception;

use Shared\Domain\Exception\DomainError;

final class OrderEmptyUser extends DomainError
{
    public function errorCode(): string
    {
        return 'order_empty_user';
    }

    public function errorMessage(): string
    {
        return 'Order needs a registered user';
    }
}
