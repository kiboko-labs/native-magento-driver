<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValue\Mutable;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableVarcharAttributeValue;
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
        return new MutableVarcharAttributeValue(
            $this->attributeRepository->findOneById($options['attribute_id']),
            $options['value'],
            $options['entity_id'],
            $options['store_id']
        );
    }
}