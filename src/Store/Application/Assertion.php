<?php

declare(strict_types=1);

namespace Store\Application;

use Store\Domain\Cart\Cart;
use Store\Domain\Cart\CartId;
use Store\Domain\Cart\Exception\CartNotFound;
use Store\Domain\Product\Exception\ProductNotFound;
use Store\Domain\Product\Product;
use Store\Domain\Product\ProductId;

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
