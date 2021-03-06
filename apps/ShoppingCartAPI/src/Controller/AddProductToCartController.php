<?php

declare(strict_types=1);

namespace ShoppingCartAPI\Controller;

use Shared\Domain\Exception\InvalidUuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use Store\ShoppingCart\Application\AddProductToCart\AddProductToCartCommand;
use Store\ShoppingCart\Domain\Cart\Exception\CartNotFound;
use Store\ShoppingCart\Domain\Cart\Exception\CartIsFull;
use Store\ShoppingCart\Domain\CartLine\Exception\InvalidQuantity;
use Store\ShoppingCart\Domain\Product\Exception\ProductNotFound;
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

        return $this->createApiResponse(null, Response::HTTP_NO_CONTENT);
    }

    protected function exceptions(): array
    {
        return [
            CartNotFound::class => Response::HTTP_NOT_FOUND,
            ProductNotFound::class => Response::HTTP_NOT_FOUND,
            CartIsFull::class => Response::HTTP_BAD_REQUEST,
            InvalidUuid::class => Response::HTTP_BAD_REQUEST,
            InvalidQuantity::class => Response::HTTP_BAD_REQUEST,
        ];
    }
}
