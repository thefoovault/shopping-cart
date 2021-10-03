<?php

declare(strict_types=1);

namespace ShoppingCart\Infrastructure\Persistence;

use Predis\Client;
use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartRepository;

final class RedisCartRepository implements CartRepository
{
    public function __construct(
        private Client $connection
    ) {}

    public function save(Cart $cart): void
    {
        $this->connection->set(
            $cart->id()->value(),
            serialize($cart)
        );
    }

    public function findById(CartId $cartId): ?Cart
    {
        $data = $this->connection->get($cartId->value());

        if (null === $data) {
            return null;
        }

        return unserialize($data);
    }

    public function delete(CartId $cartId): void
    {
        $this->connection->del($cartId->value());
    }
}
