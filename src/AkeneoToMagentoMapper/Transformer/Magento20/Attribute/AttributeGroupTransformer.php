<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer\V2_0ce\Attribute;

use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface as KibokoAttributeGroupInterface;
use Kiboko\Component\MagentoORM\Model\V2_0ce\AttributeGroup;
use Kiboko\Component\AkeneoToMagentoMapper\Transformer\Attribute\AbstractAttributeGroupTransformer;
use Pim\Component\Catalog\Model\AttributeGroupInterface as PimAttributeGroupInterface;
use Pim\Component\Catalog\Model\FamilyInterface;

class AttributeGroupTransformer extends AbstractAttributeGroupTransformer
{
    /**
     * @param PimAttributeGroupInterface $group
     *
     * @return KibokoAttributeGroupInterface[]|\Traversable
     */
    public function transform(PimAttributeGroupInterface $group)
    {
        /** @var FamilyInterface $family */
        foreach ($this->familyRepository->findAll() as $family) {
            $kibokoGroup = new AttributeGroup(
                $this->familyMapper->map($family->getCode()),
                $group->getLabel(),
                $group->getCode(),
                null,
                $group->getSortOrder(),
                0
            );

            $kibokoGroup->setMappingCode($group->getCode());
            $kibokoGroup->setParentMappingCode($family->getCode());

            yield $kibokoGroup;
        }
    }
}
