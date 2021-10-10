<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\Cart;

use Shared\Domain\Aggregate\AggregateRoot;
use Store\ShoppingCart\Domain\Cart\Exception\CartIsFull;
use Store\ShoppingCart\Domain\Cart\Exception\ProductNotFoundInCart;
use Store\ShoppingCart\Domain\CartLine\CartLine;
use Store\ShoppingCart\Domain\CartLine\CartLineQuantity;
use Store\ShoppingCart\Domain\Product\Product;
use Store\ShoppingCart\Domain\Product\ProductId;
use Store\Users\Domain\User\UserId;

final class Cart extends AggregateRoot
{
    private const MAX_CART_LINES = 5;

    private CartTotalAmount $totalAmount;
    private CartTotalNumberProducts $totalQuantity;

    public function __construct(
        private CartId $id,
        private CartLines $cartLines,
        private ?UserId $userId = null
    ) {
        $this->totalAmount = $this->calculateTotalAmount();
        $this->totalQuantity = $this->calculateTotalNumberProducts();
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
        $this->totalQuantity = $this->calculateTotalNumberProducts();
    }

    public function removeProduct(ProductId $productId): void
    {
        $cartLine = $this->cartLines()->findLineByProductId($productId);
        $this->assertProductFoundInCart($cartLine, $productId);

        $this->cartLines()->remove($productId);
    }

    public function changeProductQuantity(ProductId $productId, CartLineQuantity $cartLineQuantity): void
    {
        $cartLine = $this->cartLines()->findLineByProductId($productId);

        $this->assertProductFoundInCart($cartLine, $productId);

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

    public function userId(): ?UserId
    {
        return $this->userId;
    }

    public function totalAmount(): CartTotalAmount
    {
        return $this->totalAmount;
    }

    public function totalNumberProducts(): CartTotalNumberProducts
    {
        return $this->totalQuantity;
    }

    private function assertCartIsNotFull(): void
    {
        if ($this->cartLines()->count() >= self::MAX_CART_LINES) {
            throw new CartIsFull($this->id());
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

    private function calculateTotalNumberProducts(): CartTotalNumberProducts
    {
        $totalQuantity = new CartTotalNumberProducts(0);

        /** @var CartLine $cartLine */
        foreach ($this->cartLines() as $cartLine) {
            $totalQuantity = $totalQuantity->add($cartLine->quantity());
        }

        return $totalQuantity;
    }

    private function assertProductFoundInCart(?CartLine $cartLine, ProductId $productId): void
    {
        if (null === $cartLine) {
            throw new ProductNotFoundInCart($this->id(), $productId);
        }
    }
}
