<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application;

use Shared\Domain\Bus\Query\QueryResponse;
use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartLines;

final class CartResponse implements QueryResponse
{
    public function __construct(
        private string $id,
        private ?string $userId,
        private array $cartLines,
        private float $totalAmount,
        private int $totalNumberProducts
    ) {}

    public static function createFromCart(Cart $cart): self
    {
        return new self(
            $cart->id()->value(),
            $cart->userId() ? $cart->userId()->value() : null,
            self::createCartLines($cart->cartLines()),
            $cart->totalAmount()->value(),
            $cart->totalNumberProducts()->value()
        );
    }

    private static function createCartLines(CartLines $cartLines): array
    {
        $cartLinesResponse = [];
        foreach ($cartLines as $cartLine) {
            $cartLinesResponse[] = CartLineResponse::createFromCartLine($cartLine);
        }

        return $cartLinesResponse;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userId(): ?string
    {
        return $this->userId;
    }

    public function cartLines(): array
    {
        return $this->cartLines;
    }

    public function totalAmount(): float
    {
        return $this->totalAmount;
    }

    public function totalNumberProducts(): int
    {
        return $this->totalNumberProducts;
    }
}
