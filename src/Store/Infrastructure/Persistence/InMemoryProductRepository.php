<?php

declare(strict_types=1);

namespace Store\Infrastructure\Persistence;

use Store\Domain\Product\Product;
use Store\Domain\Product\ProductId;
use Store\Domain\Product\ProductRepository;
use Store\Infrastructure\Persistence\Data\ProductData;

final class InMemoryProductRepository implements ProductRepository
{
    private array $products;

    public function __construct()
    {
        $this->products = ProductData::products();
    }

    public function findById(ProductId $productId): ?Product
    {
        return $this->products[$productId->value()] ?? null;
    }
}
