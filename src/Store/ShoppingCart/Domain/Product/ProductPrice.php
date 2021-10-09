<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\Product;

use Shared\Domain\ValueObject\FloatValueObject;
use Store\ShoppingCart\Domain\Product\Exception\InvalidPrice;

final class ProductPrice extends FloatValueObject
{
    public function __construct(float $value)
    {
        $this->assertValidPrice($value);
        parent::__construct($value);
    }

    private function assertValidPrice(float $price): void
    {
        if ($price <= 0) {
            throw new InvalidPrice($price);
        }
    }
}
