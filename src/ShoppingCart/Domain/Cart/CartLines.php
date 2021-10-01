<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Cart;

use Shared\Domain\Aggregate\Collection;
use ShoppingCart\Domain\CartLine\CartLine;

final class CartLines extends Collection
{
    protected function type(): string
    {
        return CartLine::class;
    }
}
