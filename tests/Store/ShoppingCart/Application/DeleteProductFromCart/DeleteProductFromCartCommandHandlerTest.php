<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Application\DeleteProductFromCart;

use PHPUnit\Framework\TestCase;
use Store\ShoppingCart\Application\DeleteProductFromCart\DeleteProductFromCart;
use Store\ShoppingCart\Application\DeleteProductFromCart\DeleteProductFromCartCommand;
use Store\ShoppingCart\Application\DeleteProductFromCart\DeleteProductFromCartCommandHandler;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Store\ShoppingCart\Domain\Cart\Exception\CartNotFound;
use Store\ShoppingCart\Domain\Cart\Exception\ProductNotFoundInCart;
use Test\Store\ShoppingCart\Domain\Cart\CartIdMother;
use Test\Store\ShoppingCart\Domain\Cart\CartMother;
use Test\Store\ShoppingCart\Domain\CartLine\CartLineMother;

final class DeleteProductFromCartCommandHandlerTest extends TestCase
{
    private CartRepository $cartRepository;
    private DeleteProductFromCart $deleteProductFromCart;
    private DeleteProductFromCartCommandHandler $deleteProductFromCartCommandHandler;

    public function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepository::class);
        $this->deleteProductFromCart = new DeleteProductFromCart($this->cartRepository);
        $this->deleteProductFromCartCommandHandler = new DeleteProductFromCartCommandHandler(
            $this->deleteProductFromCart
        );
    }

    public function tearDown(): void
    {
        unset(
            $this->cartRepository,
            $this->deleteProductFromCart,
            $this->deleteProductFromCartCommandHandler
        );
    }

    /** @test */
    public function shouldDeleteAProductFromCart(): void
    {
        $cart = CartMother::randomEmptyCart();
        $cartLine = CartLineMother::random();

        $cart->addProduct($cartLine->product(), $cartLine->quantity());

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $expectedCart = unserialize(serialize($cart));
        $expectedCart->removeProduct($cartLine->product()->id());

        $this->cartRepository
            ->expects(self::once())
            ->method('save')
            ->with($expectedCart);

        $this->deleteProductFromCartCommandHandler->__invoke(
            new DeleteProductFromCartCommand(
                $cart->id()->value(),
                $cartLine->product()->id()->value()
            )
        );
    }

    /** @test */
    public function shouldThrowCartNotFoundException(): void
    {
        $this->expectException(CartNotFound::class);

        $cartId = CartIdMother::random();
        $cartLine = CartLineMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cartId)
            ->willReturn(null);

        $this->deleteProductFromCartCommandHandler->__invoke(
            new DeleteProductFromCartCommand(
                $cartId->value(),
                $cartLine->product()->id()->value()
            )
        );
    }

    /** @test */
    public function shouldThrowProductNotFoundInCartException(): void
    {
        $this->expectException(ProductNotFoundInCart::class);

        $cart = CartMother::randomEmptyCart();
        $cartLine = CartLineMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->deleteProductFromCartCommandHandler->__invoke(
            new DeleteProductFromCartCommand(
                $cart->id()->value(),
                $cartLine->product()->id()->value()
            )
        );
    }
}
