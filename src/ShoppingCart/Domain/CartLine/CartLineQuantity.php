<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\CartLine;

use Shared\Domain\ValueObject\IntegerValueObject;
use ShoppingCart\Domain\CartLine\Exception\InvalidQuantity;

final class CartLineQuantity extends IntegerValueObject
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
