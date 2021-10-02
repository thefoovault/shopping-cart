<?php

declare(strict_types=1);

namespace ShoppingCart\Infrastructure\Persistence;

use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartLines;
use ShoppingCart\Domain\Cart\CartRepository;
use ShoppingCart\Domain\Cart\CartTotalAmount;

final class RedisCartRepository implements CartRepository
{
    public function save(Cart $cart): void
    {
        // TODO: Implement save() method.
    }

    public function findById(CartId $cartId): Cart
    {
        return new Cart(
            $cartId,
            new CartLines([]),
            new CartTotalAmount(0)
        );
    }
}
