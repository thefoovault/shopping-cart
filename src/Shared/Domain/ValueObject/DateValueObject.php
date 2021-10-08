<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use DateTimeImmutable;

abstract class DateValueObject
{
    public function __construct(
        private DateTimeImmutable $dateTime
    ) {}

    public function dateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public static function now(): self
    {
        return new static(new DateTimeImmutable());
    }
}
