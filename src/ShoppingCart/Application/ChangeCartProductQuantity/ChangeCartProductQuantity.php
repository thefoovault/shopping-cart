<?php

declare(strict_types=1);

namespace ShoppingCart\Application\ChangeCartProductQuantity;

use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartRepository;
use ShoppingCart\Domain\Cart\Exception\CartNotFound;
use ShoppingCart\Domain\CartLine\CartLineQuantity;
use ShoppingCart\Domain\Product\ProductId;

final class ChangeCartProductQuantity
{
    public function __construct(
        private CartRepository $cartRepository
    ) {}

    public function __invoke(CartId $cartId, ProductId $productId, CartLineQuantity $cartLineQuantity): void
    {
        $cart = $this->cartRepository->findById($cartId);

        $this->assertCartExists($cart, $cartId);

        $cart->changeProductQuantity($productId, $cartLineQuantity);

        $this->cartRepository->save($cart);
    }

    private function assertCartExists(?Cart $cart, CartId $cartId): void
    {
        if (null === $cart) {
            throw new CartNotFound($cartId);
        }
    }
}
