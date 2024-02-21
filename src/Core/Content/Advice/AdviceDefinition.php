<?php

declare(strict_types=1);

namespace Crehler\Advice\Core\Content\Advice;

use Crehler\Advice\Core\Content\Advice\Aggregate\AdviceTranslationDefinition;
use Shopware\Core\Content\ProductStream\ProductStreamDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

#[Autoconfigure(tags: [['name' => 'shopware.entity.definition', 'entity' => 'cregler_advice']])]
class AdviceDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'crehler_advice';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return AdviceEntity::class;
    }

    public function getCollectionClass(): string
    {
        return AdviceCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new FkField(
                'product_stream_id',
                'productStreamId',
                ProductStreamDefinition::class
            ))->addFlags(new Required()),
            (new TranslatedField('name'))->addFlags(new Required()),
            (new TranslatedField('description'))->addFlags(new Required()),

            (new TranslationsAssociationField(
                AdviceTranslationDefinition::class,
                'crehler_advice_id'
            ))->addFlags(new Required()),

            new ManyToOneAssociationField(
                'productStream',
                'product_stream_id',
                ProductStreamDefinition::class,
                'id',
                false
            ),
        ]);
    }
}