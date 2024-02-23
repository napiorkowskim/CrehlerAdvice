<?php

namespace Crehler\Advice\Core\Content\Advice\Aggregate;

use Crehler\Advice\Core\Content\Advice\AdviceDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\AllowHtml;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\LongTextField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

#[Autoconfigure(tags: [['name' => 'shopware.entity.definition', 'entity' => 'crehler_advice_translation']])]
class AdviceTranslationDefinition extends EntityTranslationDefinition
{
    final public const ENTITY_NAME = 'crehler_advice_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getParentDefinitionClass(): string
    {
        return AdviceDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            (new LongTextField('description', 'description'))->addFlags(new AllowHtml()),
        ]);
    }
}
