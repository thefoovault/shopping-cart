<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\DeleteProductFromCart;

use Shared\Application\AssertionTrait;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Store\ShoppingCart\Domain\Product\ProductId;

final class DeleteProductFromCart
{
    use AssertionTrait;

    public function __construct(
        private CartRepository $cartRepository
    ) {}

    public function __invoke(CartId $cartId, ProductId $productId): void
    {
        $cart = $this->cartRepository->findById($cartId);
        $this->assertCartExists($cart, $cartId);

        $cart->removeProduct($productId);

        $this->cartRepository->save($cart);
    }
}
