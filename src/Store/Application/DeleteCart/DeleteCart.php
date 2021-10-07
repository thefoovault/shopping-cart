<?php

declare(strict_types=1);

namespace Store\Application\DeleteCart;

use Store\Application\Assertion;
use Store\Domain\Cart\CartId;
use Store\Domain\Cart\CartRepository;

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
