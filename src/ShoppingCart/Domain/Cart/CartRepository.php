<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Cart;

interface CartRepository
{
    public function save(Cart $cart): void;
}
