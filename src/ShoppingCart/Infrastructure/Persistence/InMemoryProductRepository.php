<?php

declare(strict_types=1);

namespace ShoppingCart\Infrastructure\Persistence;

use ShoppingCart\Domain\Product\Product;
use ShoppingCart\Domain\Product\ProductId;
use ShoppingCart\Domain\Product\ProductRepository;
use ShoppingCart\Infrastructure\Persistence\Data\ProductData;

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
