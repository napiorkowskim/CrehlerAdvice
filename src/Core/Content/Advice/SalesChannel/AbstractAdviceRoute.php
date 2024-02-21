<?php

declare(strict_types=1);

namespace Crehler\Advice\Core\Content\Advice\SalesChannel;

use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

abstract class AbstractAdviceRoute
{
    abstract public function getDecorated(): AbstractAdviceRoute;
    abstract public function searchAdvice(
        RequestDataBag $data,
        SalesChannelContext $context
    ): SearchAdviceResponse;
    abstract public function getAdvice(string $id, SalesChannelContext $context): AdviceResponse;
}