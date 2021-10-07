<?php

declare(strict_types=1);

namespace Store\Application\AddProductToCart;

use Store\Application\Assertion;
use Store\Domain\Cart\CartId;
use Store\Domain\Cart\CartRepository;
use Store\Domain\CartLine\CartLineQuantity;
use Store\Domain\Product\ProductId;
use Store\Domain\Product\ProductRepository;

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
