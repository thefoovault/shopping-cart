<?php

declare(strict_types=1);

namespace Shared\Application;

use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\Exception\CartNotFound;
use Store\ShoppingCart\Domain\Product\Exception\ProductNotFound;
use Store\ShoppingCart\Domain\Product\Product;
use Store\ShoppingCart\Domain\Product\ProductId;

trait AssertionTrait
{
    private function assertCartExists(?Cart $cart, CartId $cartId): void
    {
        if (null === $cart) {
            throw new CartNotFound($cartId);
        }
    }

    private function assertProductExists(?Product $product, ProductId $productId): void
    {
        if (null === $product) {
            throw new ProductNotFound($productId);
        }
    }
}
