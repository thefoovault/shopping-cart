<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Application\AddProductToCart;

use Shared\Application\AssertionTrait;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Store\ShoppingCart\Domain\CartLine\CartLineQuantity;
use Store\ShoppingCart\Domain\Product\ProductId;
use Store\ShoppingCart\Domain\Product\ProductRepository;

final class AddProductToCart
{
    use AssertionTrait;

    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository
    ) {}

    public function __invoke(CartId $cartId, ProductId $productId, CartLineQuantity $cartLineQuantity): void
    {
        $cart = $this->cartRepository->findById($cartId);
        $this->assertCartExists($cart, $cartId);

        $product = $this->productRepository->findById($productId);
        $this->assertProductExists($product, $productId);

        $cart->addProduct($product, $cartLineQuantity);

        $this->cartRepository->save($cart);
    }
}
