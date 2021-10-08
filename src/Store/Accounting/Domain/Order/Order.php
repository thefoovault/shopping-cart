<?php

declare(strict_types=1);

namespace Store\Accounting\Domain\Order;

use Shared\Domain\Aggregate\AggregateRoot;
use Store\Accounting\Domain\OrderLine\OrderLine;
use Store\Accounting\Domain\OrderLine\OrderLineQuantity;
use Store\Accounting\Domain\OrderLine\OrderLineUnitPrice;
use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartLines;
use Store\ShoppingCart\Domain\CartLine\CartLine;

final class Order extends AggregateRoot
{
    private OrderTotalAmount $totalAmount;

    public function __construct(
        private OrderId $id,
        private OrderUserId $userId,
        private OrderStatus $status,
        private OrderLines $orderLines
    ) {
        $this->totalAmount = $this->calculateTotalAmount();
    }

    public static function createFromCart(Cart $cart): self
    {
        return new self(
            OrderId::random(),
            OrderUserId::random(),
            OrderStatus::createWithPendingStatus(),
            self::createFromCartLines($cart->cartLines())
        );
    }

    private static function createFromCartLines(CartLines $cartLines): OrderLines
    {
        $orderLines = new OrderLines([]);

        /** @var CartLine $cartLine */
        foreach ($cartLines as $cartLine) {
            $orderLines->add(
                OrderLine::create(
                    new OrderLineQuantity($cartLine->quantity()->value()),
                    $cartLine->product()->id(),
                    new OrderLineUnitPrice($cartLine->product()->price()->value())
                )
            );
        }

        return $orderLines;
    }

    public function id(): OrderId
    {
        return $this->id;
    }

    public function userId(): OrderUserId
    {
        return $this->userId;
    }

    public function totalAmount(): OrderTotalAmount
    {
        return $this->totalAmount;
    }

    public function status(): OrderStatus
    {
        return $this->status;
    }

    public function orderLines(): OrderLines
    {
        return $this->orderLines;
    }

    private function calculateTotalAmount(): OrderTotalAmount
    {
        return new OrderTotalAmount(0);
    }
}
