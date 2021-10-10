<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class FloatValueObject
{
    public function __construct(
        protected float $value,
        protected int $decimals = 2
    ) {
        $this->value = (float) number_format($this->value, $this->decimals);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function add(self $value): self
    {
        return new static($value->value() + $this->value());
    }
}
