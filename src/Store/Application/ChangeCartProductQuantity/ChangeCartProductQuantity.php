<?php

declare(strict_types=1);

namespace Store\Application\ChangeCartProductQuantity;

use Store\Application\Assertion;
use Store\Domain\Cart\CartId;
use Store\Domain\Cart\CartRepository;
use Store\Domain\CartLine\CartLineQuantity;
use Store\Domain\Product\ProductId;

final class ChangeCartProductQuantity
{
    use Assertion;

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
}
