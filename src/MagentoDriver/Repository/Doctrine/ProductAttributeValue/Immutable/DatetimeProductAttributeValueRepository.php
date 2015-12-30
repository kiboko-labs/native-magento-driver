<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValue\Immutable;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableDatetimeAttributeValue;
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
        return new ImmutableDatetimeAttributeValue(
            $this->attributeRepository->findOneById($options['attribute_id']),
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $options['value']),
            $options['entity_id'],
            $options['store_id']
        );
    }
}