<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211008181110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates database structure';
    }

    public function up(Schema $schema): void
    {
        // Table "orders"
        $this->addSql("CREATE TABLE orders(
            id BINARY(16) NOT NULL,
            user_id BINARY(16) NOT NULL,
            order_status ENUM('pending', 'paid') NOT NULL,
            creation_date DATETIME NOT NULL,
            PRIMARY KEY(id)
        )
        DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        ENGINE = InnoDB");

        // Table "orders"
        $this->addSql("CREATE TABLE orders_lines(
            id BINARY(16) NOT NULL,
            order_id BINARY(16) NOT NULL,
            product_id BINARY(16) NOT NULL,
            unit_price DECIMAL(10,2) NOT NULL,
            quantity INTEGER(3) NOT NULL, 
            PRIMARY KEY(id), 
            FOREIGN KEY (order_id) REFERENCES orders(id)
        )
        DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        ENGINE = InnoDB");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE orders_lines");
        $this->addSql("DROP TABLE orders");
        $this->addSql("DROP TABLE order_status");
    }
}
