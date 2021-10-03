<?php

declare(strict_types=1);

namespace ShoppingCartAPI\Controller;

use Shared\Domain\Exception\InvalidUuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use ShoppingCart\Application\GetCart\GetCartQuery;
use ShoppingCart\Domain\Cart\Exception\CartNotFound;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetCartController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $response = $this->ask(
            new GetCartQuery($id)
        );

        return $this->createApiResponse($response);
    }

    protected function exceptions(): array
    {
        return [
            CartNotFound::class => Response::HTTP_NOT_FOUND,
            InvalidUuid::class => Response::HTTP_BAD_REQUEST,
        ];
    }
}
