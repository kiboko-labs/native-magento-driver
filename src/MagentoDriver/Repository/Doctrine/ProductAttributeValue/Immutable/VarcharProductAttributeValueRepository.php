<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValue\Immutable;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableVarcharAttributeValue;
use Luni\Component\MagentoDriver\Repository\Doctrine\AbstractProductAttributeValueRepository;

class VarcharProductAttributeValueRepository
    extends AbstractProductAttributeValueRepository
{
    /**
     * @param array $options
     * @return AttributeValueInterface
     */
    protected function createNewAttributeValueInstanceFromDatabase(array $options)
    {
        return new ImmutableVarcharAttributeValue(
            $this->attributeRepository->findOneById($options['attribute_id']),
            $options['value'],
            $options['entity_id'],
            $options['store_id']
        );
    }
}