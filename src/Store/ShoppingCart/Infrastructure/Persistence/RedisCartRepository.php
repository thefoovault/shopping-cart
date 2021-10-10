<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Infrastructure\Persistence;

use Predis\Client;
use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Domain\Cart\CartLines;
use Store\ShoppingCart\Domain\Cart\CartRepository;
use Store\ShoppingCart\Domain\CartLine\CartLine;
use Store\ShoppingCart\Domain\CartLine\CartLineId;
use Store\ShoppingCart\Domain\CartLine\CartLineQuantity;
use Store\ShoppingCart\Domain\Product\Product;
use Store\ShoppingCart\Domain\Product\ProductId;
use Store\ShoppingCart\Domain\Product\ProductName;
use Store\ShoppingCart\Domain\Product\ProductPrice;
use Store\Users\Domain\User\UserId;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class RedisCartRepository implements CartRepository
{
    private const DEFAULT_TTL = 60 * 60 * 24;
    private const REDIS_CART_KEY = 'cart:id:';
    private const EXPIRE_RESOLUTION = 'EX';

    public function __construct(
        private Client $connection,
        private SerializerInterface $serializer
    ) {}

    public function save(Cart $cart): void
    {
        $this->connection->set(
            self::REDIS_CART_KEY . $cart->id()->value(),
            $this->serializer->serialize($cart, JsonEncoder::FORMAT),
            self::EXPIRE_RESOLUTION,
            self::DEFAULT_TTL
        );
    }

    public function findById(CartId $cartId): ?Cart
    {
        $data = $this->connection->get(self::REDIS_CART_KEY . $cartId->value());

        if (null === $data) {
            return null;
        }

        $this->connection->expire(self::REDIS_CART_KEY . $cartId->value(), self::DEFAULT_TTL);

        return $this->hydrateCart(json_decode($data, true));
    }

    private function hydrateCart(array $cart): Cart
    {
        return new Cart(
            new CartId($cart['id']['value']),
            $this->hydrateCartLines($cart['cartLines']),
            isset($cart['userId']['value']) ? new UserId($cart['userId']['value']) : null
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
        $this->connection->del(self::REDIS_CART_KEY . $cartId->value());
    }
}
