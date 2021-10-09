<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\Product;

interface ProductRepository
{
    public function findById(ProductId $productId): ?Product;
}
