<?php

declare(strict_types=1);

namespace ShoppingCartAPI\Controller;

use Shared\Domain\Exception\InvalidUuid;
use Shared\Infrastructure\Symfony\Controller\ApiController;
use ShoppingCart\Application\AddProductToCart\AddProductToCartCommand;
use ShoppingCart\Domain\Cart\Exception\CartNotFound;
use ShoppingCart\Domain\Cart\Exception\FullCart;
use ShoppingCart\Domain\CartLine\Exception\InvalidQuantity;
use ShoppingCart\Domain\Product\Exception\ProductNotFound;
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
            FullCart::class => Response::HTTP_BAD_REQUEST,
            InvalidUuid::class => Response::HTTP_BAD_REQUEST,
            InvalidQuantity::class => Response::HTTP_BAD_REQUEST,
        ];
    }
}
