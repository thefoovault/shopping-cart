<?php

declare(strict_types=1);

namespace Test\Store\Application\ChangeCartProductQuantity;

use PHPUnit\Framework\TestCase;
use Store\Application\ChangeCartProductQuantity\ChangeCartProductQuantity;
use Store\Application\ChangeCartProductQuantity\ChangeCartProductQuantityCommand;
use Store\Application\ChangeCartProductQuantity\ChangeCartProductQuantityCommandHandler;
use Store\Domain\Cart\CartRepository;
use Store\Domain\Cart\Exception\CartNotFound;
use Store\Domain\Cart\Exception\ProductNotFoundInCart;
use Store\Domain\CartLine\CartLineQuantity;
use Test\Store\Domain\Cart\CartMother;
use Test\Store\Domain\Product\ProductMother;

final class ChangeCartProductQuantityCommandHandlerTest extends TestCase
{
    private CartRepository $cartRepository;
    private ChangeCartProductQuantityCommandHandler $changeCartProductQuantityCommandHandler;

    protected function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepository::class);
        $this->changeCartProductQuantityCommandHandler = new ChangeCartProductQuantityCommandHandler(
            new ChangeCartProductQuantity($this->cartRepository)
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->cartRepository,
            $this->productRepository,
            $this->changeCartProductQuantityCommandHandler
        );
    }

    /** @test */
    public function shouldChangeACartProductQuantity(): void
    {
        $cart = CartMother::randomEmptyCart();
        $product = ProductMother::random();
        $cart->addProduct($product, new CartLineQuantity(1));

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->cartRepository
            ->expects(self::once())
            ->method('save');

        $this->changeCartProductQuantityCommandHandler->__invoke(
            new ChangeCartProductQuantityCommand(
                $cart->id()->value(),
                $product->id()->value(),
                2
            )
        );
    }

    /** @test */
    public function shouldThrowProductNotFoundInCartException(): void
    {
        $this->expectException(ProductNotFoundInCart::class);

        $cart = CartMother::randomEmptyCart();
        $product = ProductMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->changeCartProductQuantityCommandHandler->__invoke(
            new ChangeCartProductQuantityCommand(
                $cart->id()->value(),
                $product->id()->value(),
                2
            )
        );
    }

    /** @test */
    public function shouldThrowCartNotFoundException(): void
    {
        $this->expectException(CartNotFound::class);

        $cart = CartMother::randomEmptyCart();
        $product = ProductMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn(null);

        $this->changeCartProductQuantityCommandHandler->__invoke(
            new ChangeCartProductQuantityCommand(
                $cart->id()->value(),
                $product->id()->value(),
                2
            )
        );
    }
}
