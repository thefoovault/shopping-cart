<?php

declare(strict_types=1);

namespace Store\Application\GetCart;

use Shared\Domain\Bus\Query\Query;

final class GetCartQuery implements Query
{
    public function __construct(
        private string $cartId
    ) {}

    public function cartId(): string
    {
        return $this->cartId;
    }
}
