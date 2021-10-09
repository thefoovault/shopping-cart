<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use Shared\Domain\Exception\InvalidQuantity;

abstract class Quantity extends IntegerValueObject
{
    public function __construct(int $value)
    {
        $this->assertValidQuantity($value);
        parent::__construct($value);
    }

    private function assertValidQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidQuantity($quantity);
        }
    }
}
