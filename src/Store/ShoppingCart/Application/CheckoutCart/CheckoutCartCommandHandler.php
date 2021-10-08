<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\CheckoutCart;

use Shared\Domain\Bus\Command\CommandHandler;
use Store\ShoppingCart\Domain\Cart\CartId;

final class CheckoutCartCommandHandler implements CommandHandler
{
    public function __construct(
        private CheckoutCart $checkoutCart
    ) {}

    public function __invoke(CheckoutCartCommand $checkoutCartCommand): void
    {
        $this->checkoutCart->__invoke(
            new CartId($checkoutCartCommand->cartId())
        );
    }
}
