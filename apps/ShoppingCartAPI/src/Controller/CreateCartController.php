<?php

declare(strict_types=1);

namespace ShoppingCartAPI\Controller;

use Shared\Domain\ValueObject\Uuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Store\ShoppingCart\Application\CreateCart\CreateCartCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateCartController extends ApiController
{
    const API_URL = 'api/carts/%s';

    public function __invoke(Request $request): Response
    {
        $id = Uuid::random()->value();

        $this->dispatch(
            new CreateCartCommand($id)
        );

        return $this->createApiResponse($this->createUrl($id), Response::HTTP_CREATED);
    }

    protected function exceptions(): array
    {
        return [];
    }

    private function createUrl(string $id): string
    {
        return sprintf(
            self::API_URL,
            $id
        );
    }
}
