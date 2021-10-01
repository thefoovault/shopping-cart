<?php

declare(strict_types=1);

namespace ShoppingCartAPI\Controller;

use Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCartController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        return $this->createApiResponse(null);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
