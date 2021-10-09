<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\CreateCart;

use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartLines;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Store\ShoppingCart\Domain\Cart\CartTotalAmount;
use Store\Users\Domain\User\UserId;

final class CreateCart
{
    public function __construct(
        private CartRepository $cartRepository
    ) {}

    public function __invoke(CartId $cartId, ?UserId $userId = null): void
    {
        $this->cartRepository->save(
            new Cart(
                $cartId,
                new CartLines([]),
                $userId
            )
        );
    }
}
