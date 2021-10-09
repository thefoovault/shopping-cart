<?php

declare(strict_types=1);

namespace ShoppingCartAPI\Controller;

use Shared\Infrastructure\Symfony\Controller\ApiController;
use Store\ShoppingCart\Application\DeleteProductFromCart\DeleteProductFromCartCommand;
use Store\ShoppingCart\Domain\Cart\Exception\CartNotFound;
use Store\ShoppingCart\Domain\Cart\Exception\ProductNotFoundInCart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RemoveProductFromCartController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $productId = $request->attributes->get('productId');

        $this->dispatch(
            new DeleteProductFromCartCommand(
                $id,
                $productId
            )
        );

        return $this->createApiResponse(null, Response::HTTP_NO_CONTENT);
    }

    protected function exceptions(): array
    {
        return [
            CartNotFound::class => Response::HTTP_NOT_FOUND,
            ProductNotFoundInCart::class => Response::HTTP_NOT_FOUND
        ];
    }
}
