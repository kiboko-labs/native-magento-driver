<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDml\V1_9ce\Attribute;

use Kiboko\Component\MagentoORM\Exception\InvalidArgumentException;
use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface as BaseAttributeGroupInterface;
use Kiboko\Component\MagentoORM\Model\V1_9ce\AttributeGroupInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoORM\Persister\StandardDml\Attribute\AttributeGroupPersisterTrait;

class AttributeGroupPersister implements AttributeGroupPersisterInterface
{
    use AttributeGroupPersisterTrait;

    /**
     * @param BaseAttributeGroupInterface $attributeGroup
     *
     * @return array
     */
    protected function getInsertData(BaseAttributeGroupInterface $attributeGroup)
    {
        if (!$attributeGroup instanceof AttributeGroupInterface) {
            throw new InvalidArgumentException(sprintf(
                'Invalid group type, expected "%s", got "%s".',
                BaseAttributeGroupInterface::class,
                is_object($attributeGroup) ? get_class($attributeGroup) : gettype($attributeGroup)
            ));
        }

        return [
            'attribute_group_id' => $attributeGroup->getId(),
            'attribute_set_id' => $attributeGroup->getFamilyId(),
            'attribute_group_name' => $attributeGroup->getLabel(),
            'sort_order' => $attributeGroup->getSortOrder(),
            'default_id' => $attributeGroup->getDefaultId(),
        ];
    }

    /**
     * @return array
     */
    protected function getUpdatedFields()
    {
        return [
            'attribute_set_id',
            'attribute_group_name',
            'sort_order',
            'default_id',
        ];
    }

    /**
     * @return string
     */
    protected function getIdentifierField()
    {
        return 'attribute_group_id';
    }
}
