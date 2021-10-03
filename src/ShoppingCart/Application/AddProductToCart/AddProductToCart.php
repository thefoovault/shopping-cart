<?php

declare(strict_types=1);

namespace ShoppingCart\Application\AddProductToCart;

use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartRepository;
use ShoppingCart\Domain\Cart\Exception\CartNotFound;
use ShoppingCart\Domain\CartLine\CartLineQuantity;
use ShoppingCart\Domain\Product\Exception\ProductNotFound;
use ShoppingCart\Domain\Product\Product;
use ShoppingCart\Domain\Product\ProductId;
use ShoppingCart\Domain\Product\ProductRepository;

final class AddProductToCart
{
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

    private function assertCartExists(?Cart $cart, CartId $cartId): void
    {
        if (null === $cart) {
            throw new CartNotFound($cartId);
        }
    }

    private function assertProductExists(?Product $product, ProductId $productId): void
    {
        if (null === $product) {
            throw new ProductNotFound($productId);
        }
    }
}
