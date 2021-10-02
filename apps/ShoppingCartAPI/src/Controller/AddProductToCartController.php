<?php

declare(strict_types=1);

namespace ShoppingCartAPI\Controller;

use Shared\Infrastructure\Symfony\Controller\ApiController;
use ShoppingCart\Application\AddProductToCart\AddProductToCartCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AddProductToCartController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $payload = $this->getPayload($request);

        $this->dispatch(
            new AddProductToCartCommand(
                $id,
                $payload['productId'],
                $payload['productQuantity']
            )
        );

        return $this->createApiResponse(null);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
