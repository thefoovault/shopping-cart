<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\CartLine\Exception;

use Shared\Domain\Exception\DomainError;

final class InvalidQuantity extends DomainError
{
    private int $cartLineQuantity;

    public function __construct(int $cartLineQuantity)
    {
        $this->cartLineQuantity = $cartLineQuantity;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_quantity';
    }

    public function errorMessage(): string
    {
        return sprintf(
            '%s is an invalid quantity',
            $this->cartLineQuantity
        );
    }
}
