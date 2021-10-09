<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\DeleteProductFromCart;

use Shared\Domain\Bus\Command\CommandHandler;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Product\ProductId;

final class DeleteProductFromCartCommandHandler implements CommandHandler
{
    public function __construct(
        private DeleteProductFromCart $deleteProductFromCart
    ) {}

    public function __invoke(DeleteProductFromCartCommand $deleteProductFromCartCommand): void
    {
        $this->deleteProductFromCart->__invoke(
            new CartId($deleteProductFromCartCommand->cartId()),
            new ProductId($deleteProductFromCartCommand->productId())
        );
    }
}
