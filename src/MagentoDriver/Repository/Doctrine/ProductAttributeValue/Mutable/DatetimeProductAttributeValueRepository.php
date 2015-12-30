<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValue\Mutable;

use Luni\Component\MagentoDriver\ModelValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\ModelValue\Mutable\MutableDatetimeAttributeValue;
use Luni\Component\MagentoDriver\Repository\Doctrine\AbstractProductAttributeValueRepository;

class DatetimeProductAttributeValueRepository
    extends AbstractProductAttributeValueRepository
{
    /**
     * @param array $options
     * @return AttributeValueInterface
     */
    protected function createNewAttributeValueInstanceFromDatabase(array $options)
    {
        return new MutableDatetimeAttributeValue(
            $this->attributeRepository->findOneById($options['attribute_id']),
            \DateTimeMutable::createFromFormat('Y-m-d H:i:s', $options['value']),
            $options['entity_id'],
            $options['store_id']
        );
    }
}