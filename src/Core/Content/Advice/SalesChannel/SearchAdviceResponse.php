<?php

namespace Crehler\Advice\Core\Content\Advice\SalesChannel;

use Shopware\Core\Framework\DataAbstractionLayer\Search\IdSearchResult;
use Shopware\Core\System\SalesChannel\StoreApiResponse;

class SearchAdviceResponse extends StoreApiResponse
{
    public function getAdvice(): IdSearchResult
    {
        return $this->object;
    }
}
