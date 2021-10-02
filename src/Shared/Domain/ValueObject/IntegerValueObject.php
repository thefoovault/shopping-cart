<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class IntegerValueObject
{
    public function __construct(
        protected int $value
    ) {}

    public function value(): int
    {
        return $this->value;
    }

    public function add(self $value): static
    {
        return new static($value->value() + $this->value());
    }
}
