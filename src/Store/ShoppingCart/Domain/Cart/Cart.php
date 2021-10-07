<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\Cart;

use Shared\Domain\Aggregate\AggregateRoot;
use Store\ShoppingCart\Domain\Cart\Exception\FullCart;
use Store\ShoppingCart\Domain\Cart\Exception\ProductNotFoundInCart;
use Store\ShoppingCart\Domain\CartLine\CartLine;
use Store\ShoppingCart\Domain\CartLine\CartLineQuantity;
use Store\ShoppingCart\Domain\Product\Product;
use Store\ShoppingCart\Domain\Product\ProductId;

final class Cart extends AggregateRoot
{
    private const MAX_CART_LINES = 5;

    private CartTotalAmount $totalAmount;

    public function __construct(
        private CartId $id,
        private CartLines $cartLines
    ) {
        $this->totalAmount = $this->calculateTotalAmount();
    }

    public function addProduct(Product $product, CartLineQuantity $lineQuantity): void
    {
        $this->assertCartIsNotFull();
        $cartLine = $this->cartLines()->findLineByProductId($product->id());

        if (null === $cartLine) {
            $cartLine = CartLine::create($product, $lineQuantity);
            $this->cartLines->add($cartLine);
        } else {
            $cartLine->changeQuantity(
                $cartLine->incrementLineQuantity($lineQuantity)
            );
        }

        $this->totalAmount = $this->calculateTotalAmount();
    }

    public function changeProductQuantity(ProductId $productId, CartLineQuantity $cartLineQuantity): void
    {
        $cartLine = $this->cartLines()->findLineByProductId($productId);

        if (null === $cartLine) {
            throw new ProductNotFoundInCart($this->id(), $productId);
        }

        $cartLine->changeQuantity($cartLineQuantity);

        $this->totalAmount = $this->calculateTotalAmount();
    }

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

    private function assertCartIsNotFull(): void
    {
        if ($this->cartLines()->count() >= self::MAX_CART_LINES) {
            throw new FullCart($this->id());
        }
    }

    private function calculateTotalAmount(): CartTotalAmount
    {
        $totalAmount = new CartTotalAmount(0);

        /** @var CartLine $cartLine */
        foreach ($this->cartLines() as $cartLine) {
            $totalAmount = $totalAmount->add($cartLine->amount());
        }

        return $totalAmount;
    }
}
