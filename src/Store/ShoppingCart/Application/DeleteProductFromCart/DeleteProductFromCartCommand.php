<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\DeleteProductFromCart;

use Shared\Domain\Bus\Command\Command;

final class DeleteProductFromCartCommand implements Command
{
    public function __construct(
        private string $cartId,
        private string $productId
    ) {}

    public function cartId(): string
    {
        return $this->cartId;
    }

    public function productId(): string
    {
        return $this->productId;
    }
}
