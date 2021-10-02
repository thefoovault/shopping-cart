<?php

declare(strict_types=1);

namespace ShoppingCartAPI\Controller;

use Shared\Infrastructure\Symfony\Controller\ApiController;
use ShoppingCart\Application\DeleteCart\DeleteCartCommand;
use ShoppingCart\Domain\Cart\Exception\CartNotFound;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DeleteCartController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $this->dispatch(
            new DeleteCartCommand($id)
        );

        return $this->createApiResponse(null);
    }

    protected function exceptions(): array
    {
        return [
            CartNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
