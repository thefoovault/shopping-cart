<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Product;

use Shared\Domain\Aggregate\AggregateRoot;

final class Product extends AggregateRoot
{
    public function __construct(
        private ProductId $id,
        private ProductName $name,
        private ProductPrice $price
    ) {}

    public function id(): ProductId
    {
        return $this->id;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }
}
