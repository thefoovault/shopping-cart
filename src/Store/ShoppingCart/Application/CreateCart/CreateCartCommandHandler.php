<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\CreateCart;

use Shared\Domain\Bus\Command\CommandHandler;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\Users\Domain\User\UserId;

final class CreateCartCommandHandler implements CommandHandler
{
    public function __construct(
        private CreateCart $createCart
    ) {}

    public function __invoke(CreateCartCommand $createCartCommand): void
    {
        $this->createCart->__invoke(
            new CartId($createCartCommand->cartId()),
            $createCartCommand->userId() ? new UserId($createCartCommand->userId()) : null
        );
    }
}
