<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Cart;

use Shared\Domain\Aggregate\AggregateRoot;

final class Cart extends AggregateRoot
{
    public function __construct(
        private CartId $id,
        private CartLines $cartLines,
        private CartTotalAmount $totalAmount
    ) {}

    public function id(): CartId
    {
        return $this->id;
    }

    public function cartLines(): CartLines
    {
        return $this->cartLines;
    }

    public function totalAmount(): CartTotalAmount
    {
        return $this->totalAmount;
    }
}
