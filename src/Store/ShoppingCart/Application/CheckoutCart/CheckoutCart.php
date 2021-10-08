<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\CheckoutCart;

use Shared\Application\AssertionTrait;
use Store\Accounting\Application\CreateOrder\CreateOrderFromCart;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartRepository;

final class CheckoutCart
{
    use AssertionTrait;

    public function __construct(
        private CartRepository $cartRepository,
        private CreateOrderFromCart $createOrderFromCart
    ) {}

    public function __invoke(CartId $cartId): void
    {
        $cart = $this->cartRepository->findById($cartId);
        $this->assertCartExists($cart, $cartId);

        $this->createOrderFromCart->__invoke($cart);

        $this->cartRepository->delete($cartId);
    }
}
