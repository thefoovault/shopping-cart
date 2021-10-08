<?php

declare(strict_types=1);

namespace Store\Accounting\Domain\OrderLine;

use Store\ShoppingCart\Domain\Product\ProductId;

final class OrderLine
{
    private OrderLineAmount $amount;

    public function __construct(
        private OrderLineId $id,
        private OrderLineQuantity $quantity,
        private ProductId $productId,
        private OrderLineUnitPrice $unitPrice
    ) {
        $this->amount = $this->calculateLineAmount($this->quantity, $this->unitPrice);
    }

    public static function create(
        OrderLineQuantity $lineQuantity,
        ProductId $productId,
        OrderLineUnitPrice $unitPrice
    ): self
    {
        return new self(
            OrderLineId::random(),
            $lineQuantity,
            $productId,
            $unitPrice
        );
    }

    public function id(): OrderLineId
    {
        return $this->id;
    }

    public function quantity(): OrderLineQuantity
    {
        return $this->quantity;
    }

    public function productId(): ProductId
    {
        return $this->productId;
    }

    public function unitPrice(): OrderLineUnitPrice
    {
        return $this->unitPrice;
    }

    private function calculateLineAmount(OrderLineQuantity $lineQuantity, OrderLineUnitPrice $productPrice): OrderLineAmount
    {
        return new OrderLineAmount($lineQuantity->value() * $productPrice->value());
    }
}
