<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Application\AddProductToCart;

use PHPUnit\Framework\TestCase;
use Store\ShoppingCart\Application\AddProductToCart\AddProductToCart;
use Store\ShoppingCart\Application\AddProductToCart\AddProductToCartCommand;
use Store\ShoppingCart\Application\AddProductToCart\AddProductToCartCommandHandler;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Store\ShoppingCart\Domain\Cart\Exception\CartNotFound;
use Store\ShoppingCart\Domain\Cart\Exception\FullCart;
use Store\ShoppingCart\Domain\Product\Exception\ProductNotFound;
use Store\ShoppingCart\Domain\Product\ProductRepository;
use Test\Store\ShoppingCart\Domain\Cart\CartMother;
use Test\Store\ShoppingCart\Domain\CartLine\CartLineMother;

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
    public function shouldAddAnExistingProductToACart(): void
    {
        $cart = CartMother::randomEmptyCart();
        $cartLine = CartLineMother::random();
        $cart->addProduct($cartLine->product(), $cartLine->quantity());

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
                1
            )
        );
    }

    /** @test */
    public function shouldThrowCartNotFoundException(): void
    {
        $this->expectException(CartNotFound::class);

        $cart = CartMother::randomFullCart();
        $cartLine = CartLineMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn(null);

        $this->addProductToCartCommandHandler->__invoke(
            new AddProductToCartCommand(
                $cart->id()->value(),
                $cartLine->product()->id()->value(),
                $cartLine->quantity()->value()
            )
        );
    }

    /** @test */
    public function shouldThrowProductNotFoundException(): void
    {
        $this->expectException(ProductNotFound::class);

        $cart = CartMother::randomFullCart();
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
            ->willReturn(null);

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

        $cart = CartMother::randomFullCart();
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
