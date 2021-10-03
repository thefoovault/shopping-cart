<?php

declare(strict_types=1);

namespace ShoppingCart\Application;

use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\Exception\CartNotFound;
use ShoppingCart\Domain\Product\Exception\ProductNotFound;
use ShoppingCart\Domain\Product\Product;
use ShoppingCart\Domain\Product\ProductId;

trait Assertion
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
