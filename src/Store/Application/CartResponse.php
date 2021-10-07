<?php

declare(strict_types=1);

namespace Store\Application;

use Shared\Domain\Bus\Query\QueryResponse;
use Store\Domain\Cart\Cart;
use Store\Domain\Cart\CartLines;

final class CartResponse implements QueryResponse
{
    public function __construct(
        private string $id,
        private array $cartLines,
        private float $totalAmount
    ) {}

    public static function createFromCart(Cart $cart): self
    {
        return new self(
            $cart->id()->value(),
            self::createCartLines($cart->cartLines()),
            $cart->totalAmount()->value()
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

    public function cartLines(): array
    {
        return $this->cartLines;
    }

    public function totalAmount(): float
    {
        return $this->totalAmount;
    }
}
