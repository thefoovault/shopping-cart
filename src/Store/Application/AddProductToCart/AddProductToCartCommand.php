<?php

declare(strict_types=1);

namespace Store\Application\AddProductToCart;

use Shared\Domain\Bus\Command\Command;

final class AddProductToCartCommand implements Command
{
    public function __construct(
        private string $cartId,
        private string $productId,
        private int $productQuantity
    ) {}

    public function cartId(): string
    {
        return $this->cartId;
    }

    public function productId(): string
    {
        return $this->productId;
    }

    public function productQuantity(): int
    {
        return $this->productQuantity;
    }
}
