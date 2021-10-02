<?php

declare(strict_types=1);

namespace ShoppingCart\Application\CreateCart;

use Shared\Domain\Bus\Command\Command;

final class CreateCartCommand implements Command
{
    public function __construct(
        private string $cartId
    ){}

    public function cartId(): string
    {
        return $this->cartId;
    }
}