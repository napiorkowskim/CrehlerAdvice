<?php

namespace Crehler\Advice\Struct;

use Shopware\Core\Framework\Struct\Struct;

class AdviceStruct extends Struct
{
    public const NAME = 'advice';

    public function __construct(
        public readonly string $id,
    ) {
    }

}