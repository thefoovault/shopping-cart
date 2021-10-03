<?php

declare(strict_types=1);

namespace ShoppingCart\Infrastructure\Persistence;

use Predis\Client;
use ShoppingCart\Domain\Cart\Cart;
use ShoppingCart\Domain\Cart\CartId;
use ShoppingCart\Domain\Cart\CartLines;
use ShoppingCart\Domain\Cart\CartRepository;
use ShoppingCart\Domain\CartLine\CartLine;
use ShoppingCart\Domain\CartLine\CartLineId;
use ShoppingCart\Domain\CartLine\CartLineQuantity;
use ShoppingCart\Domain\Product\Product;
use ShoppingCart\Domain\Product\ProductId;
use ShoppingCart\Domain\Product\ProductName;
use ShoppingCart\Domain\Product\ProductPrice;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class RedisCartRepository implements CartRepository
{
    private const DEFAULT_TTL = 60 * 60 * 24;

    public function __construct(
        private Client $connection,
        private SerializerInterface $serializer
    ) {}

    public function save(Cart $cart): void
    {
        $this->connection->set(
            $cart->id()->value(),
            $this->serializer->serialize($cart, JsonEncoder::FORMAT),
            'EX',
            self::DEFAULT_TTL
        );
    }

    public function findById(CartId $cartId): ?Cart
    {
        $data = $this->connection->get($cartId->value());

        if (null === $data) {
            return null;
        }

        $this->connection->expire($cartId->value(), self::DEFAULT_TTL);

        return $this->hydrateCart(json_decode($data, true));
    }

    private function hydrateCart(array $cart): Cart
    {
        return new Cart(
            new CartId($cart['id']['value']),
            $this->hydrateCartLines($cart['cartLines'])
        );
    }

    private function hydrateCartLines(array $lines): CartLines
    {
        $cartLines = [];
        foreach ($lines as $line) {
            $cartLines[] = $this->hydrateCartLine($line);
        }

        return new CartLines($cartLines);
    }

    private function hydrateCartLine(array $line): CartLine
    {
        return new CartLine(
            new CartLineId($line['id']['value']),
            $this->hydrateProduct($line['product']),
            new CartLineQuantity($line['quantity']['value'])
        );
    }

    private function hydrateProduct(array $product): Product
    {
        return new Product(
            new ProductId($product['id']['value']),
            new ProductName($product['name']['value']),
            new ProductPrice($product['price']['value'])
        );
    }

    public function delete(CartId $cartId): void
    {
        $this->connection->del($cartId->value());
    }
}
