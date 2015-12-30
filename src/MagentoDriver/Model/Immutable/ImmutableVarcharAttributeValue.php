<?php

namespace Luni\Component\MagentoDriver\ModelValue\Immutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\ModelValue\Mutable\MutableVarcharAttributeValue;
use Luni\Component\MagentoDriver\ModelValue\VarcharAttributeValueInterface;
use Luni\Component\MagentoDriver\ModelValue\VarcharAttributeValueTrait;

class ImmutableVarcharAttributeValue
    implements ImmutableAttributeValueInterface, VarcharAttributeValueInterface
{
    use VarcharAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param string $payload
     * @param int $productId
     * @param int $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        $payload,
        $productId = null,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        $this->payload = $payload;
        $this->productId = $productId;
        $this->storeId = (int) $storeId;
    }

    /**
     * @return MutableVarcharAttributeValue
     */
    public function switchToMutable()
    {
        return MutableVarcharAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->productId,
            $this->storeId
        );
    }
}