<?php

namespace Crehler\Advice\Core\Content\Advice\SalesChannel;

use Crehler\Advice\Core\Content\Advice\AdviceEntity;
use Shopware\Core\System\SalesChannel\StoreApiResponse;

class AdviceResponse extends StoreApiResponse
{
    public function getAdvice(): AdviceEntity
    {
        return $this->object;
    }
}
