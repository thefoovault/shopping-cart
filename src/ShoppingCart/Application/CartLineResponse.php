<?php

declare(strict_types=1);

namespace ShoppingCart\Application;

use Shared\Domain\Bus\Query\QueryResponse;
use ShoppingCart\Domain\CartLine\CartLine;

final class CartLineResponse implements QueryResponse, \JsonSerializable
{
    public function __construct(
        private string $id,
        private ProductResponse $product,
        private float $quantity,
        private float $amount
    ) {}

    public static function createFromCartLine(CartLine $cartLine): self
    {
        return new self(
            $cartLine->id()->value(),
            ProductResponse::createFromProduct($cartLine->product()),
            $cartLine->lineQuantity()->value(),
            $cartLine->amount()->value()
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function product(): ProductResponse
    {
        return $this->product;
    }

    public function quantity(): float
    {
        return $this->quantity;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id(),
            'product' => $this->product(),
            'quantity' => $this->quantity(),
            'amount' => $this->amount()
        ];
    }
}
