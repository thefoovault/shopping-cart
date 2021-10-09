<?php

declare(strict_types=1);

namespace Store\ShoppingCart\Domain\CartLine;

use Shared\Domain\ValueObject\IntegerValueObject;
use Shared\Domain\ValueObject\Quantity;
use Store\ShoppingCart\Domain\CartLine\Exception\InvalidQuantity;

final class CartLineQuantity extends Quantity
{
}
