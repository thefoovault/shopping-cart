<?php

declare(strict_types=1);

namespace ShoppingCart\Application\GetCart;

use ShoppingCart\Application\Assertion;
use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartRepository;

final class GetCart
{
    use Assertion;

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
