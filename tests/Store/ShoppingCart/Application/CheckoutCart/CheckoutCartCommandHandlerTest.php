<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Application\CheckoutCart;

use PHPUnit\Framework\TestCase;
use Store\Accounting\Application\CreateOrder\CreateOrderFromCart;
use Store\Accounting\Domain\Order\Exception\EmptyOrderLines;
use Store\Accounting\Domain\Order\Exception\OrderEmptyUser;
use Store\Accounting\Domain\Order\OrderRepository;
use Store\ShoppingCart\Application\CheckoutCart\CheckoutCart;
use Store\ShoppingCart\Application\CheckoutCart\CheckoutCartCommand;
use Store\ShoppingCart\Application\CheckoutCart\CheckoutCartCommandHandler;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Test\Store\ShoppingCart\Domain\Cart\CartMother;

final class CheckoutCartCommandHandlerTest extends TestCase
{
    private CartRepository $cartRepository;
    private OrderRepository $orderRepository;
    private CreateOrderFromCart $createOrderFromCart;
    private CheckoutCartCommandHandler $checkoutCartCommandHandler;

    protected function setUp(): void
    {
        $this->cartRepository = $this->createMock(CartRepository::class);
        $this->orderRepository = $this->createMock(OrderRepository::class);
        $this->createOrderFromCart = new CreateOrderFromCart($this->orderRepository);
        $this->checkoutCartCommandHandler = new CheckoutCartCommandHandler(
            new CheckoutCart($this->cartRepository, $this->createOrderFromCart)
        );
    }

    protected function tearDown(): void
    {
        unset(
            $this->cartRepository,
            $this->orderRepository,
            $this->createOrderFromCart,
            $this->checkoutCartCommandHandler
        );
    }

    /** @test */
    public function shouldCheckoutACart(): void
    {
        $cart = CartMother::random();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->orderRepository
            ->expects(self::once())
            ->method('save');

        $this->cartRepository
            ->expects(self::once())
            ->method('delete');

        $this->checkoutCartCommandHandler->__invoke(
            new CheckoutCartCommand(
                $cart->id()->value()
            )
        );
    }

    /** @test */
    public function shouldThrowOrderLinesEmptyException(): void
    {
        $this->expectException(EmptyOrderLines::class);
        $cart = CartMother::randomEmptyCart();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->checkoutCartCommandHandler->__invoke(
            new CheckoutCartCommand(
                $cart->id()->value()
            )
        );
    }

    /** @test */
    public function shouldThrowOrderEmptyUserException(): void
    {
        $this->expectException(OrderEmptyUser::class);
        $cart = CartMother::randomEmptyUser();

        $this->cartRepository
            ->expects(self::once())
            ->method('findById')
            ->with($cart->id())
            ->willReturn($cart);

        $this->checkoutCartCommandHandler->__invoke(
            new CheckoutCartCommand(
                $cart->id()->value()
            )
        );
    }
}
