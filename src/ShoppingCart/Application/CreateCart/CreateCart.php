<?php

declare(strict_types=1);

namespace ShoppingCart\Application\CreateCart;

use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartLines;
use ShoppingCart\Domain\Cart\CartRepository;
use ShoppingCart\Domain\Cart\CartTotalAmount;

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
