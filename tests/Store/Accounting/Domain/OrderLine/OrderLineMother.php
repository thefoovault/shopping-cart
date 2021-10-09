<?php

declare(strict_types=1);

namespace Test\Store\Accounting\Domain\OrderLine;

use Store\Accounting\Domain\OrderLine\OrderLine;
use Store\Accounting\Domain\OrderLine\OrderLineId;
use Store\Accounting\Domain\OrderLine\OrderLineQuantity;
use Store\Accounting\Domain\OrderLine\OrderLineUnitPrice;
use Store\ShoppingCart\Domain\Product\ProductId;

final class OrderLineMother
{
    public static function create(
        OrderLineId $orderLineId,
        OrderLineQuantity $orderLineQuantity,
        ProductId $orderLineProductId,
        OrderLineUnitPrice $orderLineUnitPrice
    ): OrderLine
    {
        return new OrderLine(
            $orderLineId,
            $orderLineQuantity,
            $orderLineProductId,
            $orderLineUnitPrice
        );
    }

    public static function random(): OrderLine
    {
        return self::create(
            OrderLineIdMother::random(),
            OrderLineQuantityMother::random(),
            ProductId::random(),
            OrderLineUnitPriceMother::random()
        );
    }
}
