<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\CreateCart;

use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartLines;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Store\ShoppingCart\Domain\Cart\CartTotalAmount;

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
