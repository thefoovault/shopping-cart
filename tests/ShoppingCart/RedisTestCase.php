<?php

declare(strict_types=1);

namespace Test\ShoppingCart;

use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

class RedisTestCase extends KernelTestCase
{
    public function connection(): Client
    {
        return $this->getContainer()->get(Client::class);
    }

    public function serializer(): SerializerInterface
    {
        return $this->getContainer()->get(SerializerInterface::class);
    }
}
