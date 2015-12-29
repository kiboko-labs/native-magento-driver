<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValue\Immutable;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableTextAttributeValue;
use Luni\Component\MagentoDriver\Repository\Doctrine\AbstractProductAttributeValueRepository;

class TextProductAttributeValueRepository
    extends AbstractProductAttributeValueRepository
{
    /**
     * @param array $options
     * @return AttributeValueInterface
     */
    protected function createNewAttributeValueInstanceFromDatabase(array $options)
    {
        return new ImmutableTextAttributeValue(
            $this->attributeRepository->findOneById($options['attribute_id']),
            $options['value'],
            $options['entity_id'],
            $options['store_id']
        );
    }
}