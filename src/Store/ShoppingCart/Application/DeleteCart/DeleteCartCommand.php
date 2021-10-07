<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\DeleteCart;

use Shared\Domain\Bus\Command\Command;

final class DeleteCartCommand implements Command
{
    public function __construct(
        private string $cartId
    ) {}

    public function cartId(): string
    {
        return $this->cartId;
    }
}
