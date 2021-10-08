<?php

declare(strict_types=1);

namespace Store\Accounting\Domain\Order;

use Shared\Domain\Aggregate\AggregateRoot;
use Store\Accounting\Domain\Order\Exception\OrderEmptyUser;
use Store\Accounting\Domain\OrderLine\OrderLine;
use Store\Accounting\Domain\OrderLine\OrderLineQuantity;
use Store\Accounting\Domain\OrderLine\OrderLineUnitPrice;
use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartLines;
use Store\ShoppingCart\Domain\CartLine\CartLine;
use Store\Users\Domain\User\UserId;

final class Order extends AggregateRoot
{
    private OrderTotalAmount $totalAmount;

    public function __construct(
        private OrderId $id,
        private UserId $userId,
        private OrderStatus $status,
        private OrderLines $orderLines,
        private OrderCreationDate $creationDate
    ) {
        $this->totalAmount = $this->calculateTotalAmount();
    }

    public static function createFromCart(Cart $cart): self
    {
        self::assertExistingUser($cart->userId());

        return new self(
            OrderId::random(),
            $cart->userId(),
            OrderStatus::createWithPendingStatus(),
            self::createFromCartLines($cart->cartLines()),
            OrderCreationDate::now()
        );
    }

    private static function assertExistingUser(?UserId $userId): void
    {
        if (null === $userId) {
            throw new OrderEmptyUser();
        }
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

    public function userId(): UserId
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

    public function creationDate(): OrderCreationDate
    {
        return $this->creationDate;
    }

    private function calculateTotalAmount(): OrderTotalAmount
    {
        return new OrderTotalAmount(0);
    }
}
