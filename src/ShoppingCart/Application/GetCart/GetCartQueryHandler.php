<?php

declare(strict_types=1);

namespace ShoppingCart\Application\GetCart;

use Shared\Domain\Bus\Query\QueryHandler;
use ShoppingCart\Application\CartResponse;
use ShoppingCart\Domain\Cart\CartId;

final class GetCartQueryHandler implements QueryHandler
{
    public function __construct(
        private GetCart $getCart
    ) {}

    public function __invoke(GetCartQuery $getCartQuery): CartResponse
    {
        $cart = $this->getCart->__invoke(
            new CartId($getCartQuery->cartId())
        );

        return CartResponse::createFromCart($cart);
    }
}
