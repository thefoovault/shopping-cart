<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Application\DeleteCart;

use PHPUnit\Framework\TestCase;
use Store\ShoppingCart\Application\DeleteCart\DeleteCart;
use Store\ShoppingCart\Application\DeleteCart\DeleteCartCommand;
use Store\ShoppingCart\Application\DeleteCart\DeleteCartCommandHandler;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Store\ShoppingCart\Domain\Cart\Exception\CartNotFound;
use Test\Store\ShoppingCart\Domain\Cart\CartIdMother;
use Test\Store\ShoppingCart\Domain\Cart\CartMother;

final class DeleteCartCommandHandlerTest extends TestCase
{
    private CartRepository $cartRepository;
    private DeleteCartCommandHandler $deleteCartCommandHandler;

    protected function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepository::class);
        $this->deleteCartCommandHandler = new DeleteCartCommandHandler(
            new DeleteCart($this->cartRepository)
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->cartRepository,
            $this->deleteCartCommandHandler
        );
    }

    /** @test */
    public function shouldCreateACart(): void
    {
        $cart = CartMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->cartRepository
            ->expects(self::once())
            ->method('delete')
            ->with($cart->id());

        $this->deleteCartCommandHandler->__invoke(
            new DeleteCartCommand($cart->id()->value())
        );
    }

    /** @test */
    public function shouldThrowCartNotFoundException(): void
    {
        $this->expectException(CartNotFound::class);

        $cartId = CartIdMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cartId)
            ->willReturn(null);

        $this->deleteCartCommandHandler->__invoke(
            new DeleteCartCommand($cartId->value())
        );
    }
}
