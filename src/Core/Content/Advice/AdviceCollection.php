<?php

declare(strict_types=1);

namespace Crehler\Advice\Core\Content\Advice;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class AdviceCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return AdviceEntity::class;
    }
}
