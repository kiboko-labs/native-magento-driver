<?php

namespace Luni\Component\MagentoDriver\Backend\Attribute;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\TextAttributeValueInterface;
use Luni\Component\MagentoDriver\Backend\BaseCsvBackendTrait;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\InvalidAttributeBackendTypeException;

class TextAttributeBackend
    implements BackendInterface
{
    use BaseCsvBackendTrait;

    public function initialize()
    {
        if (empty($this->tableKeys)) {
            $this->tableKeys = [
                'value_id',
                'entity_type_id',
                'attribute_id',
                'store_id',
                'entity_id',
                'value',
            ];
        }
    }

    /**
     * @param ProductInterface $product
     * @param AttributeValueInterface $value
     */
    public function persist(ProductInterface $product, AttributeValueInterface $value)
    {
        if (!$value instanceof TextAttributeValueInterface) {
            throw new InvalidAttributeBackendTypeException();
        }

        $this->temporaryWriter->persistRow([
            'value_id'       => $value->getId(),
            'entity_type_id' => 4,
            'attribute_id'   => $value->getAttributeId(),
            'store_id'       => $value->getStoreId(),
            'entity_id'      => $product->getId(),
            'value'          => $value->getValue(),
        ]);
    }
}