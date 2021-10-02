<?php

declare(strict_types=1);

namespace Test\ShoppingCart\Application\GetCart;

use PHPUnit\Framework\TestCase;
use ShoppingCart\Application\GetCart\GetCart;
use ShoppingCart\Application\GetCart\GetCartQuery;
use ShoppingCart\Application\GetCart\GetCartQueryHandler;
use ShoppingCart\Domain\Cart\CartRepository;
use Test\ShoppingCart\Domain\Cart\CartMother;

final class GetCartQueryHandlerTest extends TestCase
{
    private CartRepository $cartRepository;
    private GetCartQueryHandler $getCartQueryHandler;

    protected function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepository::class);
        $this->getCartQueryHandler = new GetCartQueryHandler(
            new GetCart($this->cartRepository)
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->cartRepository,
            $this->getCartQueryHandler
        );
    }

    /** @test */
    public function shouldGetACart(): void
    {
        $cart = CartMother::randomEmptyCart();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->getCartQueryHandler->__invoke(
            new GetCartQuery($cart->id()->value())
        );
    }
}
