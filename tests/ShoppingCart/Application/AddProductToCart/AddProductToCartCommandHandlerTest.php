<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Application\AddProductToCart;

use PHPUnit\Framework\TestCase;
use ShoppingCart\Application\AddProductToCart\AddProductToCart;
use ShoppingCart\Application\AddProductToCart\AddProductToCartCommand;
use ShoppingCart\Application\AddProductToCart\AddProductToCartCommandHandler;
use ShoppingCart\Domain\Cart\CartRepository;
use ShoppingCart\Domain\Cart\Exception\FullCart;
use ShoppingCart\Domain\Product\ProductRepository;
use Test\ShoppingCart\Domain\Cart\CartMother;
use Test\ShoppingCart\Domain\CartLine\CartLineMother;

final class AddProductToCartCommandHandlerTest extends TestCase
{
    private CartRepository $cartRepository;
    private ProductRepository $productRepository;
    private AddProductToCartCommandHandler $addProductToCartCommandHandler;

    protected function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepository::class);
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->addProductToCartCommandHandler = new AddProductToCartCommandHandler(
            new AddProductToCart($this->cartRepository, $this->productRepository)
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->cartRepository,
            $this->productRepository,
            $this->addProductToCartCommandHandler
        );
    }

    /** @test */
    public function shouldAddAProductToACart(): void
    {
        $cart = CartMother::random();
        $cartLine = CartLineMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->productRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cartLine->product()->id())
            ->willReturn($cartLine->product());

        $this->cartRepository
            ->expects(self::once())
            ->method('save');

        $this->addProductToCartCommandHandler->__invoke(
            new AddProductToCartCommand(
                $cart->id()->value(),
                $cartLine->product()->id()->value(),
                $cartLine->quantity()->value()
            )
        );
    }

    /** @test */
    public function shouldThrowFullCartException(): void
    {
        $this->expectException(FullCart::class);

        $cart = CartMother::fullCart();
        $cartLine = CartLineMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->productRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cartLine->product()->id())
            ->willReturn($cartLine->product());

        $this->addProductToCartCommandHandler->__invoke(
            new AddProductToCartCommand(
                $cart->id()->value(),
                $cartLine->product()->id()->value(),
                $cartLine->quantity()->value()
            )
        );
    }
}
