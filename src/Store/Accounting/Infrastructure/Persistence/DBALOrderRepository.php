<?php

declare(strict_types=1);

namespace Store\Accounting\Infrastructure\Persistence;

use Doctrine\DBAL\Driver\Connection;
use Store\Accounting\Domain\Order\Order;
use Store\Accounting\Domain\Order\OrderRepository;
use Store\Accounting\Domain\OrderLine\OrderLine;

final class DBALOrderRepository implements OrderRepository
{
    public function __construct(
        private Connection $connection
    ){}

    public function save(Order $order): void
    {
        $this->connection->beginTransaction();

        try {
            $query = <<<SQL
INSERT INTO orders (id, user_id, order_status, creation_date) 
VALUES (UUID_TO_BIN(:id), UUID_TO_BIN(:user_id), :order_status, :creation_date)
SQL;
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue('id', $order->id()->value());
            $stmt->bindValue('user_id', $order->userId()->value());
            $stmt->bindValue('order_status', $order->status()->value());
            $stmt->bindValue('creation_date', $order->creationDate()->dateTime()->format(DATE_ATOM));

            $stmt->execute();

            $query = <<<SQL
INSERT INTO orders_lines (id, order_id, product_id, unit_price, quantity) 
VALUES (UUID_TO_BIN(:id), UUID_TO_BIN(:order_id), UUID_TO_BIN(:product_id), :unit_price, :quantity)
SQL;
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue('order_id', $order->id()->value());

            /** @var OrderLine $orderLine */
            foreach ($order->orderLines() as $orderLine) {
                $stmt->bindValue('id', $orderLine->id()->value());
                $stmt->bindValue('product_id', $orderLine->productId()->value());
                $stmt->bindValue('unit_price', $orderLine->unitPrice()->value());
                $stmt->bindValue('quantity', $orderLine->quantity()->value());

                $stmt->execute();
            }
        } catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }

        $this->connection->commit();
    }
}
