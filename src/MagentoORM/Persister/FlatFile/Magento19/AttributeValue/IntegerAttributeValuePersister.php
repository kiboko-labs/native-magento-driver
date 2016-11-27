<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\StandardDml\Magento19\AttributeValue;

use Kiboko\Component\MagentoORM\Model\AttributeValueInterface as BaseAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\Magento19\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\IntegerAttributeValueInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeValuePersisterInterface;
use Kiboko\Component\MagentoORM\Exception\InvalidAttributePersisterTypeException;
use Kiboko\Component\MagentoORM\Persister\FlatFile\Attribute\AttributeValuePersisterTrait;

class IntegerAttributeValuePersister implements AttributeValuePersisterInterface
{
    use AttributeValuePersisterTrait;

    /**
     * @param BaseAttributeValueInterface $value
     */
    public function persist(BaseAttributeValueInterface $value)
    {
        if (!$value instanceof AttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type, expected "%s", got "%s".',
                AttributeValueInterface::class,
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }
        if (!$value instanceof IntegerAttributeValueInterface) {
            throw new InvalidAttributePersisterTypeException(sprintf(
                'Invalid attribute value type, expected "%s", got "%s".',
                IntegerAttributeValueInterface::class,
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        $this->temporaryWriter->persistRow([
            'value_id' => $value->getId(),
            'entity_type_id' => $value->getEntityTypeId(),
            'attribute_id' => $value->getAttributeId(),
            'store_id' => $value->getStoreId(),
            'entity_id' => $value->getProductId(),
            'value' => $value->getValue() !== null ? (int) $value->getValue() : null,
        ]);
    }
}
