<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\Cart;

use Shared\Domain\Aggregate\Collection;
use Store\ShoppingCart\Domain\CartLine\CartLine;
use Store\ShoppingCart\Domain\Product\ProductId;

final class CartLines extends Collection
{
    protected function type(): string
    {
        return CartLine::class;
    }

    public function findLineByProductId(ProductId $productId): ?CartLine
    {
        /** @var CartLine $item */
        foreach ($this->items as $item) {
            if ($item->product()->id()->equals($productId)) {
                return $item;
            }
        }

        return null;
    }
}