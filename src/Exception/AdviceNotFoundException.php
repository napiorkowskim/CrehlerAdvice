<?php

namespace Crehler\Advice\Exception;

use Shopware\Core\Framework\ShopwareHttpException;
use Symfony\Component\HttpFoundation\Response;

class AdviceNotFoundException extends ShopwareHttpException
{
    public function __construct(string $id)
    {
        parent::__construct(
            'Advice for id {{ id }} not found.',
            ['id' => $id]
        );
    }

    public function getErrorCode(): string
    {
        return 'CONTENT__ADVICE_NOT_FOUND';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}