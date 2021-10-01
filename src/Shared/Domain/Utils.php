<?php

declare(strict_types=1);

namespace Shared\Domain;

use ReflectionClass;

final class Utils
{
    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $text));
    }

    public static function extractClassName(object $object): string
    {
        $reflect = new ReflectionClass($object);

        return $reflect->getShortName();
    }
}
