<?php

declare(strict_types=1);

namespace ShoppingCart\Application\ChangeCartProductQuantity;

use ShoppingCart\Application\Assertion;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartRepository;
use ShoppingCart\Domain\CartLine\CartLineQuantity;
use ShoppingCart\Domain\Product\ProductId;

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
