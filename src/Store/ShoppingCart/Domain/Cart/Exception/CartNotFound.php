<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\Cart\Exception;

use Shared\Domain\Exception\DomainError;
use Store\ShoppingCart\Domain\Cart\CartId;

final class CartNotFound extends DomainError
{
    private CartId $cartId;

    public function __construct(CartId $cartId)
    {
        $this->cartId = $cartId;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'cart_not_found';
    }

    public function errorMessage(): string
    {
       return sprintf(
           'Cart %s not found',
           $this->cartId->value()
       );
    }
}
