<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\GetCart;

use Shared\Application\AssertionShoppingCartTrait;
use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartRepository;

final class GetCart
{
    use AssertionShoppingCartTrait;

    public function __construct(
        private CartRepository $cartRepository
    ) {}

    public function __invoke(CartId $cartId): Cart
    {
        $cart = $this->cartRepository->findById($cartId);

        $this->assertCartExists($cart, $cartId);

        return $cart;
    }
}
