<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\CheckoutCart;

use Shared\Domain\Bus\Command\Command;

final class CheckoutCartCommand implements Command
{
    public function __construct(
        private string $cartId
    ) {}

    public function cartId(): string
    {
        return $this->cartId;
    }
}
