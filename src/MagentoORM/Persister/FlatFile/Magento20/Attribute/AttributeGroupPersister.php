<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\FlatFile\V2_0ce\Attribute;

use Kiboko\Component\MagentoORM\Exception\InvalidArgumentException;
use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface as BaseAttributeGroupInterface;
use Kiboko\Component\MagentoORM\Model\V2_0ce\AttributeGroupInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoORM\Persister\FlatFile\Attribute\AttributeGroupPersisterTrait;

class AttributeGroupPersister implements AttributeGroupPersisterInterface
{
    use AttributeGroupPersisterTrait;

    /**
     * @param BaseAttributeGroupInterface $attributeGroup
     *
     * @return array
     */
    public function persist(BaseAttributeGroupInterface $attributeGroup)
    {
        if (!$attributeGroup instanceof AttributeGroupInterface) {
            throw new InvalidArgumentException(sprintf(
                'Invalid group type, expected "%s", got "%s".',
                BaseAttributeGroupInterface::class,
                is_object($attributeGroup) ? get_class($attributeGroup) : gettype($attributeGroup)
            ));
        }

        $this->temporaryWriter->persistRow([
            'attribute_group_id' => $attributeGroup->getId(),
            'attribute_set_id' => $attributeGroup->getFamilyId(),
            'attribute_group_name' => $attributeGroup->getLabel(),
            'sort_order' => $attributeGroup->getSortOrder(),
            'default_id' => $attributeGroup->getDefaultId(),
            'attribute_group_code' => $attributeGroup->getAttributeGroupCode(),
            'tab_group_code' => $attributeGroup->getTabGroupCode(),
        ]);
    }
}
