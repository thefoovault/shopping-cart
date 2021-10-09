<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Infrastructure\Persistence;

use Store\ShoppingCart\Domain\Product\Product;
use Store\ShoppingCart\Domain\Product\ProductId;
use Store\ShoppingCart\Domain\Product\ProductRepository;
use Store\ShoppingCart\Infrastructure\Persistence\Data\ProductData;

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
