<?php

declare(strict_types=1);

namespace Test\Store\Accounting\Infrastructure\Persistence;

use Store\Accounting\Infrastructure\Persistence\DBALOrderRepository;
use Test\DBALTestCase;
use Test\Store\Accounting\Domain\Order\OrderMother;

final class DBALOrderRepositoryTest extends DBALTestCase
{
    private DBALOrderRepository $orderRepository;

    public function setUp(): void
    {
        $this->orderRepository = new DBALOrderRepository($this->connection());
        parent::setUp();
    }

    /** @test */
    public function shouldSaveAnOrder(): void
    {
        $order = OrderMother::random();

        $this->orderRepository->save($order);
    }
}
