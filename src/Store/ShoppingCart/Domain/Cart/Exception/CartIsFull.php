<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\Cart\Exception;

use Shared\Domain\Exception\DomainError;
use Store\ShoppingCart\Domain\Cart\CartId;

final class CartIsFull extends DomainError
{
    private CartId $cartId;

    public function __construct(CartId $cartId)
    {
        $this->cartId = $cartId;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'full_cart';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'Cart %s is full and does not accept any more items',
            $this->cartId->value()
        );
    }
}
