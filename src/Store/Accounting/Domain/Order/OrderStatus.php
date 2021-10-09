<?php

declare(strict_types=1);

namespace Store\Accounting\Domain\Order;

use Shared\Domain\ValueObject\StringValueObject;

final class OrderStatus extends StringValueObject
{
    private const PENDING = 'pending';
    private const PAID = 'paid';

    private function __construct(string $value)
    {
        parent::__construct($value);
    }

    public static function createWithPendingStatus(): self
    {
        return new self(self::PENDING);
    }

    public static function createWithPaidStatus(): self
    {
        return new self(self::PAID);
    }
}
