<?php

declare(strict_types=1);

namespace Test\Store\ShoppingCart\Infrastructure\Persistence;

use Store\ShoppingCart\Domain\Cart\Cart;
use Store\ShoppingCart\Domain\Cart\CartId;
use Store\ShoppingCart\Infrastructure\Persistence\RedisCartRepository;
use Test\Store\ShoppingCart\Domain\Cart\CartMother;
use Test\RedisTestCase;

final class RedisCartRepositoryTest extends RedisTestCase
{
    private const DEFAULT_CART_KEY = 'b79cb3f6-14dc-4566-8724-61245e29b2ce';

    private RedisCartRepository $cartRepository;
    private CartId $cartId;

    public function setUp(): void
    {
        $this->cartId = new CartId(self::DEFAULT_CART_KEY);
        $this->cartRepository = new RedisCartRepository(
            $this->connection(),
            $this->serializer()
        );
    }

    public function tearDown(): void
    {
        $this->cartRepository->delete($this->cartId);
        unset(
            $this->cartRepository
        );
    }

    /** @test */
    public function shouldSaveACart(): void
    {
        $sampleCart = CartMother::withKey($this->cartId);

        $this->cartRepository->save($sampleCart);
    }

    /** @test */
    public function shouldGetACart(): void
    {
        $sampleCart = CartMother::withKey($this->cartId);

        $this->cartRepository->save($sampleCart);

        $cart = $this->cartRepository->findById($this->cartId);

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertEquals($sampleCart, $cart);
    }

    /** @test */
    public function shouldGetAnEmptyCart(): void
    {
        $cart = $this->cartRepository->findById(CartId::random());

        $this->assertNull($cart);
    }

    /** @test */
    public function shouldDeleteACart(): void
    {
        $sampleCart = CartMother::withKey($this->cartId);

        $this->cartRepository->save($sampleCart);

        $this->cartRepository->delete($this->cartId);
    }
}
