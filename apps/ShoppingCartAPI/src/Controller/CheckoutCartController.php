<?php

declare(strict_types=1);

namespace ShoppingCartAPI\Controller;

use Shared\Infrastructure\Symfony\Controller\ApiController;
use Store\Accounting\Domain\Order\Exception\EmptyOrderLines;
use Store\Accounting\Domain\Order\Exception\OrderEmptyUser;
use Store\ShoppingCart\Application\CheckoutCart\CheckoutCartCommand;
use Store\ShoppingCart\Domain\Cart\Exception\CartNotFound;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CheckoutCartController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $id = $request->attributes->get('id');

        $this->dispatch(
            new CheckoutCartCommand(
                $id
            )
        );

        return $this->createApiResponse(null, Response::HTTP_NO_CONTENT);
    }

    protected function exceptions(): array
    {
        return [
            CartNotFound::class => Response::HTTP_NOT_FOUND,
            OrderEmptyUser::class => Response::HTTP_BAD_REQUEST,
            EmptyOrderLines::class => Response::HTTP_BAD_REQUEST
        ];
    }
}
