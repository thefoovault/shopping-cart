<?php

declare(strict_types=1);

namespace Store\Application\CreateCart;

use Shared\Domain\Bus\Command\CommandHandler;
use Store\Domain\Cart\CartId;

final class CreateCartCommandHandler implements CommandHandler
{
    public function __construct(
        private CreateCart $createCart
    ) {}

    public function __invoke(CreateCartCommand $createCartCommand): void
    {
        $this->createCart->__invoke(
            new CartId($createCartCommand->cartId())
        );
    }
}
