<?php

declare(strict_types=1);

namespace Store\Application\GetCart;

use Store\Application\Assertion;
use Store\Domain\Cart\Cart;
use Store\Domain\Cart\CartId;
use Store\Domain\Cart\CartRepository;

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
