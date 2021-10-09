<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\DeleteCart;

use Shared\Domain\Bus\Command\CommandHandler;
use Store\ShoppingCart\Domain\Cart\CartId;

final class DeleteCartCommandHandler implements CommandHandler
{
    public function __construct(
        private DeleteCart $deleteCart
    ) {}

    public function __invoke(DeleteCartCommand $deleteCartCommand): void
    {
        $this->deleteCart->__invoke(
            new CartId($deleteCartCommand->cartId())
        );
    }
}
