<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\Cart\Exception;

use Shared\Domain\Exception\DomainError;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Product\ProductId;

final class ProductNotFoundInCart extends DomainError
{
    private CartId $cartId;
    private ProductId $productId;

    public function __construct(CartId $cartId, ProductId $productId)
    {
        $this->cartId = $cartId;
        $this->productId = $productId;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'product_not_found_in_cart';
    }

    public function errorMessage(): string
    {
        return sprintf(
            'Product %s not found in cart %s',
            $this->cartId->value(),
            $this->productId->value()
        );
    }
}
