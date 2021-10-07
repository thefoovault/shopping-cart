<?php

declare(strict_types=1);

namespace Store\Domain\CartLine;

use Store\Domain\Product\Product;
use Store\Domain\Product\ProductPrice;

final class CartLine
{
    private CartLineAmount $amount;

    public function __construct(
        private CartLineId $id,
        private Product $product,
        private CartLineQuantity $quantity
    ) {
        $this->amount = $this->calculateLineAmount(
            $this->quantity,
            $this->product->price()
        );
    }

    public static function create(Product $product, CartLineQuantity $lineQuantity): self
    {
        return new self(
            CartLineId::random(),
            $product,
            $lineQuantity
        );
    }

    public function incrementLineQuantity(CartLineQuantity $lineQuantity): CartLineQuantity
    {
        return $this->quantity()->add($lineQuantity);
    }

    public function changeQuantity(CartLineQuantity $lineQuantity): void
    {
        $this->quantity = $lineQuantity;
        $this->amount = $this->calculateLineAmount($this->quantity, $this->product->price());
    }

    public function id(): CartLineId
    {
        return $this->id;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function quantity(): CartLineQuantity
    {
        return $this->quantity;
    }

    public function amount(): CartLineAmount
    {
        return $this->amount;
    }

    private function calculateLineAmount(CartLineQuantity $lineQuantity, ProductPrice $productPrice): CartLineAmount
    {
        return new CartLineAmount($lineQuantity->value() * $productPrice->value());
    }
}
