<?php

namespace Luni\Component\MagentoDriver\Model\Immutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\IntegerAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Mutable\MutableIntegerAttributeValue;
use Luni\Component\MagentoDriver\Model\IntegerAttributeValueTrait;

class ImmutableIntegerAttributeValue
    implements ImmutableAttributeValueInterface, IntegerAttributeValueInterface
{
    use IntegerAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param int $payload
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
     * @return MutableIntegerAttributeValue
     */
    public function switchToMutable()
    {
        return MutableIntegerAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->productId,
            $this->storeId
        );
    }
}