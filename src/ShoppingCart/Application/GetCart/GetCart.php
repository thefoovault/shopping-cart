<?php

declare(strict_types=1);

namespace ShoppingCart\Application\GetCart;

use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartRepository;
use ShoppingCart\Domain\Cart\Exception\CartNotFound;

final class GetCart
{
    public function __construct(
        private CartRepository $cartRepository
    ) {}

    public function __invoke(CartId $cartId): Cart
    {
        $cart = $this->cartRepository->findById($cartId);

        $this->assertCartExists($cart, $cartId);

        return $cart;
    }

    private function assertCartExists(?Cart $cart, CartId $cartId): void
    {
        if (null === $cart) {
            throw new CartNotFound($cartId);
        }
    }
}
