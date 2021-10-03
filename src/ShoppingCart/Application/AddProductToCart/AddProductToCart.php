<?php

declare(strict_types=1);

namespace ShoppingCart\Application\AddProductToCart;

use ShoppingCart\Application\Assertion;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartRepository;
use ShoppingCart\Domain\CartLine\CartLineQuantity;
use ShoppingCart\Domain\Product\ProductId;
use ShoppingCart\Domain\Product\ProductRepository;

final class AddProductToCart
{
    use Assertion;

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
