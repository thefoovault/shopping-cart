<?php

declare(strict_types=1);

namespace Store\Application\CreateCart;

use Store\Domain\Cart\Cart;
use Store\Domain\Cart\CartId;
use Store\Domain\Cart\CartLines;
use Store\Domain\Cart\CartRepository;
use Store\Domain\Cart\CartTotalAmount;

final class CreateCart
{
    public function __construct(
        private CartRepository $cartRepository
    ) {}

    public function __invoke(CartId $cartId): void
    {
        $this->cartRepository->save(
            new Cart(
                $cartId,
                new CartLines([])
            )
        );
    }
}
