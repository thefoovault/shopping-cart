<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Application\CheckoutCart;

use PHPUnit\Framework\TestCase;
use Store\Accounting\Application\CreateOrder\CreateOrderFromCart;
use Store\ShoppingCart\Application\CheckoutCart\CheckoutCart;
use Store\ShoppingCart\Application\CheckoutCart\CheckoutCartCommand;
use Store\ShoppingCart\Application\CheckoutCart\CheckoutCartCommandHandler;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Test\Store\ShoppingCart\Domain\Cart\CartMother;

final class CheckoutCartCommandHandlerTest extends TestCase
{
    private CartRepository $cartRepository;
    private CreateOrderFromCart $createOrderFromCart;
    private CheckoutCartCommandHandler $checkoutCartCommandHandler;

    protected function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepository::class);
        $this->createOrderFromCart = $this->createMock(CreateOrderFromCart::class);
        $this->checkoutCartCommandHandler = new CheckoutCartCommandHandler(
            new CheckoutCart($this->cartRepository, $this->createOrderFromCart)
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->cartRepository,
            $this->createOrderFromCart,
            $this->checkoutCartCommandHandler
        );
    }

    /** @test */
    public function shouldCheckoutACart(): void
    {
        $cart = CartMother::randomEmptyCart();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->createOrderFromCart
            ->expects(self::once())
            ->method('__invoke')
            ->with($cart);

        $this->cartRepository
            ->expects(self::once())
            ->method('delete');

        $this->checkoutCartCommandHandler->__invoke(
            new CheckoutCartCommand(
                $cart->id()->value()
            )
        );
    }
}
