<?php

declare(strict_types=1);

namespace ShoppingCart\Infrastructure\Persistence;

use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartRepository;

final class RedisCartRepository implements CartRepository
{
    public function save(Cart $cart): void
    {
        // TODO: Implement save() method.
    }
}
