<?php

declare(strict_types=1);

namespace Test\Store\Users\Domain\User;

use Faker\Factory;
use Store\Users\Domain\User\UserId;

final class UserIdMother
{
    public static function create(string $userId): UserId
    {
        return new UserId($userId);
    }

   public static function random(): UserId
   {
       return self::create(Factory::create()->uuid());
   }
}
