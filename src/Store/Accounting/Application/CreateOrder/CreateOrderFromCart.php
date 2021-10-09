<?php

declare(strict_types=1);

namespace Store\Accounting\Application\CreateOrder;

use Store\Accounting\Domain\Order\Order;
use Store\Accounting\Domain\Order\OrderRepository;
use Store\ShoppingCart\Domain\Cart\Cart;

final class CreateOrderFromCart
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function __invoke(Cart $cart): void
    {
        $order = Order::createFromCart($cart);
        $this->orderRepository->save($order);
    }
}
