<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\DeleteCart;

use Shared\Application\AssertionTrait;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartRepository;

final class DeleteCart
{
    use AssertionTrait;

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
