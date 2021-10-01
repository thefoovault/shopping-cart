<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\CartLine;

use ShoppingCart\Domain\Product\Product;

final class CartLine
{
    public function __construct(
        private CartLineId $id,
        private Product $product,
        private CartLineQuantity $lineQuantity,
        private CartLineAmount $amount
    ) {}

    public function id(): CartLineId
    {
        return $this->id;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function lineQuantity(): CartLineQuantity
    {
        return $this->lineQuantity;
    }

    public function amount(): CartLineAmount
    {
        return $this->amount;
    }
}
