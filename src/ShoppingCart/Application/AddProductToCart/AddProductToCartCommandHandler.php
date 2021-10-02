<?php

declare(strict_types=1);

namespace ShoppingCart\Application\AddProductToCart;

use Shared\Domain\Bus\Command\CommandHandler;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\CartLine\CartLineQuantity;
use ShoppingCart\Domain\Product\ProductId;

final class AddProductToCartCommandHandler implements CommandHandler
{
    public function __construct(
        private AddProductToCart $addProductToCart
    ) {}

    public function __invoke(AddProductToCartCommand $addProductToCartCommand): void
    {
        $this->addProductToCart->__invoke(
            new CartId($addProductToCartCommand->cartId()),
            new ProductId($addProductToCartCommand->productId()),
            new CartLineQuantity($addProductToCartCommand->productQuantity())
        );
    }
}
