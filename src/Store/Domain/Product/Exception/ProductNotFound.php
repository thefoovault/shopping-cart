<?php

declare(strict_types=1);

namespace Store\Domain\Product\Exception;

use Shared\Domain\Exception\DomainError;
use Store\Domain\Product\ProductId;

final class ProductNotFound extends DomainError
{
    private ProductId $productId;

    public function __construct(ProductId $productId)
    {
        $this->productId = $productId;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'product_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'Product %s not found',
            $this->productId->value()
        );
    }
}
