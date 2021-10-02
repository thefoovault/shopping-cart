<?php

declare(strict_types=1);

namespace ShoppingCart\Application\GetCart;

use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartRepository;

final class GetCart
{
    public function __construct(
        private CartRepository $cartRepository
    ) {}

    public function __invoke(CartId $cartId): Cart
    {
        return $this->cartRepository->findById($cartId);
    }
}
