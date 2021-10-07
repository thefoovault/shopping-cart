<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\ChangeCartProductQuantity;

use Shared\Domain\Bus\Command\CommandHandler;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\CartLine\CartLineQuantity;
use Store\ShoppingCart\Domain\Product\ProductId;

final class ChangeCartProductQuantityCommandHandler implements CommandHandler
{
    public function __construct(
        private ChangeCartProductQuantity $changeCartProductQuantity
    ) {}

    public function __invoke(ChangeCartProductQuantityCommand $changeCartProductQuantityCommand): void
    {
        $this->changeCartProductQuantity->__invoke(
            new CartId($changeCartProductQuantityCommand->cartId()),
            new ProductId($changeCartProductQuantityCommand->productId()),
            new CartLineQuantity($changeCartProductQuantityCommand->productQuantity())
        );
    }
}
