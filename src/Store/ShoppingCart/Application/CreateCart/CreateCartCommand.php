<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\CreateCart;

use Shared\Domain\Bus\Command\Command;

final class CreateCartCommand implements Command
{
    public function __construct(
        private string $cartId,
        private ?string $userId = null
    ) {}

    public function cartId(): string
    {
        return $this->cartId;
    }

    public function userId(): ?string
    {
        return $this->userId;
    }
}
