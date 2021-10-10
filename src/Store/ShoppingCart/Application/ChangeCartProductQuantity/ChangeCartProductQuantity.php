<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\ChangeCartProductQuantity;

use Shared\Application\AssertionShoppingCartTrait;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Store\ShoppingCart\Domain\CartLine\CartLineQuantity;
use Store\ShoppingCart\Domain\Product\ProductId;

final class ChangeCartProductQuantity
{
    use AssertionShoppingCartTrait;

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
