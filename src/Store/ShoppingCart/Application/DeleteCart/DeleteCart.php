<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\DeleteCart;

use Shared\Application\AssertionShoppingCartTrait;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartRepository;

final class DeleteCart
{
    use AssertionShoppingCartTrait;

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
