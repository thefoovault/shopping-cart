<?php

declare(strict_types=1);

namespace Store\Domain\Product;

interface ProductRepository
{
    public function findById(ProductId $productId): ?Product;
}
