<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\CartLine;

use ShoppingCart\Domain\Product\Product;
use ShoppingCart\Domain\Product\ProductPrice;

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

    public function incrementLineQuantity(CartLineQuantity $lineQuantity): void
    {
        $this->quantity = $this->quantity()->add($lineQuantity);
        $this->amount =$this->calculateLineAmount($this->quantity, $this->product()->price());
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
