<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Application\CreateCart;

use PHPUnit\Framework\TestCase;
use Store\ShoppingCart\Application\CreateCart\CreateCart;
use Store\ShoppingCart\Application\CreateCart\CreateCartCommand;
use Store\ShoppingCart\Application\CreateCart\CreateCartCommandHandler;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Test\Store\ShoppingCart\Domain\Cart\CartMother;

final class CreateCartCommandHandlerTest extends TestCase
{
    private CartRepository $cartRepository;
    private CreateCartCommandHandler $createCartCommandHandler;

    protected function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepository::class);
        $this->createCartCommandHandler = new CreateCartCommandHandler(
            new CreateCart($this->cartRepository)
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->cartRepository,
            $this->createCartCommandHandler
        );
    }

    /** @test */
    public function shouldCreateACart(): void
    {
        $cart = CartMother::randomEmptyCart();

        $this->cartRepository
            ->expects(self::once())
            ->method('save')
            ->with($cart);

        $this->createCartCommandHandler->__invoke(
            new CreateCartCommand($cart->id()->value())
        );
    }
}
