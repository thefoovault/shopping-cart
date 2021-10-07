<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Infrastructure\Persistence\Data;

use Store\ShoppingCart\Domain\Product\Product;
use Store\ShoppingCart\Domain\Product\ProductId;
use Store\ShoppingCart\Domain\Product\ProductName;
use Store\ShoppingCart\Domain\Product\ProductPrice;

final class ProductData
{
    public static function products(): array
    {
        return [
            '7e5070c0-e287-4cab-b267-0d399665aac6' => new Product(
                new ProductId('7e5070c0-e287-4cab-b267-0d399665aac6'),
                new ProductName('V1 Copenhagen'),
                new ProductPrice(39.99)
            ),
            '85e5e2cb-cb4e-4a51-861e-8919c9ddc515' => new Product(
                new ProductId('85e5e2cb-cb4e-4a51-861e-8919c9ddc515'),
                new ProductName('K3 All Mountain'),
                new ProductPrice(39.49)
            ),
            'ba213198-5ec3-45e0-be6f-93e0ca007907' => new Product(
                new ProductId('ba213198-5ec3-45e0-be6f-93e0ca007907'),
                new ProductName('Pirate Kid'),
                new ProductPrice(12)
            )
        ];
    }
}
