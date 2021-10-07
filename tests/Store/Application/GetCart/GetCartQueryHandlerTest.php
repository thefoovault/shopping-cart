<?php

declare(strict_types=1);

namespace Test\Store\Application\GetCart;

use PHPUnit\Framework\TestCase;
use Store\Application\GetCart\GetCart;
use Store\Application\GetCart\GetCartQuery;
use Store\Application\GetCart\GetCartQueryHandler;
use Store\Domain\Cart\CartRepository;
use Test\Store\Domain\Cart\CartMother;

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
