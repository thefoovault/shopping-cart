<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\Product\Exception;

use Shared\Domain\Exception\DomainError;

final class InvalidPrice extends DomainError
{
    private float $productPrice;

    public function __construct(float $productPrice)
    {
        $this->productPrice = $productPrice;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_price';
    }

    public function errorMessage(): string
    {
        return sprintf(
            '%f is invalid',
            $this->productPrice
        );
    }
}
