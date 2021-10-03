<?php

declare(strict_types=1);

namespace ShoppingCart\Application\DeleteCart;

use ShoppingCart\Application\Assertion;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartRepository;

final class DeleteCart
{
    use Assertion;

    public function __construct(
        private CartRepository $cartRepository
    ) {}

    public function __invoke(CartId $cartId)
    {
        $cart = $this->cartRepository->findById($cartId);

        $this->assertCartExists($cart, $cartId);

        $this->cartRepository->delete($cartId);
    }
}
