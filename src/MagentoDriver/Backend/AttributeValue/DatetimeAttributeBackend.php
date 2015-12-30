<?php

namespace Luni\Component\MagentoDriver\Backend\AttributeValue;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\DatetimeAttributeValueInterface;
use Luni\Component\MagentoDriver\Backend\BaseCsvBackendTrait;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\InvalidAttributeBackendTypeException;

class DatetimeAttributeBackend
    implements BackendInterface
{
    use BaseCsvBackendTrait;

    public function initialize()
    {
    }

    /**
     * @param ProductInterface $product
     * @param AttributeValueInterface $value
     */
    public function persist(ProductInterface $product, AttributeValueInterface $value)
    {
        if (!$value instanceof DatetimeAttributeValueInterface) {
            throw new InvalidAttributeBackendTypeException();
        }

        $this->temporaryWriter->persistRow([
            'value_id'       => $value->getId(),
            'entity_type_id' => 4,
            'attribute_id'   => $value->getAttributeId(),
            'store_id'       => $value->getStoreId(),
            'entity_id'      => $product->getId(),
            'value'          => $value->getValue()->format('Y-m-d H:i:s'),
        ]);
    }
}