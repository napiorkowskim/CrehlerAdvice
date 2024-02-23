<?php

namespace Crehler\Advice\Core\Content\Advice\Aggregate;

use Crehler\Advice\Core\Content\Advice\AdviceDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;
use Shopware\Core\System\SalesChannel\SalesChannelDefinition;

#[Autoconfigure(tags: [['name' => 'shopware.entity.definition', 'entity' => 'crehler_advice_sales_channel']])]
class AdviceSalesChannelDefinition extends MappingEntityDefinition
{
    final public const ENTITY_NAME = 'crehler_advice_sales_channel';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField(
                'crehler_advice_id',
                'productAdviceId',
                AdviceDefinition::class
            ))->addFlags(new PrimaryKey(), new Required()),

            (new FkField(
                'sales_channel_id',
                'salesChannelId',
                SalesChannelDefinition::class
            ))->addFlags(new PrimaryKey(), new Required()),

            new ManyToOneAssociationField(
                'advice',
                'advice_id',
                AdviceDefinition::class,
                'id',
                false
            ),
            new ManyToOneAssociationField(
                'salesChannel',
                'sales_channel_id',
                SalesChannelDefinition::class,
                'id',
                false
            ),
        ]);
    }
}
