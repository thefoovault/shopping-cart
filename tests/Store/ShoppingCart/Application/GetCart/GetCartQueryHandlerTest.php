<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Application\GetCart;

use PHPUnit\Framework\TestCase;
use Store\ShoppingCart\Application\CartLineResponse;
use Store\ShoppingCart\Application\CartResponse;
use Store\ShoppingCart\Application\GetCart\GetCart;
use Store\ShoppingCart\Application\GetCart\GetCartQuery;
use Store\ShoppingCart\Application\GetCart\GetCartQueryHandler;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Test\Store\ShoppingCart\Domain\Cart\CartMother;

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
        $cart = CartMother::randomFullCart();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $expectedResponse = CartResponse::createFromCart($cart);

        $response  = $this->getCartQueryHandler->__invoke(
            new GetCartQuery($cart->id()->value())
        );

        $this->assertEquals($expectedResponse->id(), $response->id());
        $this->assertEquals($expectedResponse->totalAmount(), $response->totalAmount());
        $this->assertCount(count($expectedResponse->cartLines()), $response->cartLines());
        $this->assertContainsOnlyInstancesOf(CartLineResponse::class, $response->cartLines());
    }
}
