<?php

declare(strict_types=1);

namespace ShoppingCart\Application;

use Shared\Domain\Bus\Query\QueryResponse;
use ShoppingCart\Domain\Product\Product;

final class ProductResponse implements QueryResponse
{
    public function __construct(
        private string $id,
        private string $name,
        private float $unitPrice
    ) {}

    public static function createFromProduct(Product $product): self
    {
        return new self(
            $product->id()->value(),
            $product->name()->value(),
            $product->price()->value()
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function unitPrice(): float
    {
        return $this->unitPrice;
    }
}
