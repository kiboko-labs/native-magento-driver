<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Magento19\Attribute;

use Kiboko\Component\MagentoDriver\Exception\InvalidArgumentException;
use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface as BaseAttributeGroupInterface;
use Kiboko\Component\MagentoDriver\Model\Magento19\AttributeGroupInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\AttributeGroupPersisterTrait;

class AttributeGroupPersister implements AttributeGroupPersisterInterface
{
    use AttributeGroupPersisterTrait;

    /**
     * @param BaseAttributeGroupInterface $attributeGroup
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
            'attribute_group_id'   => $attributeGroup->getId(),
            'attribute_set_id'     => $attributeGroup->getFamilyId(),
            'attribute_group_name' => $attributeGroup->getLabel(),
            'sort_order'           => $attributeGroup->getSortOrder(),
            'default_id'           => $attributeGroup->getDefaultId(),
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