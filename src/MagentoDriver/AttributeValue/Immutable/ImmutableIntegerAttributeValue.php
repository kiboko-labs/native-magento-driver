<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\IntegerAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableIntegerAttributeValue;
use Luni\Component\MagentoDriver\AttributeValue\IntegerAttributeValueTrait;

class ImmutableIntegerAttributeValue
    implements ImmutableAttributeValueInterface, IntegerAttributeValueInterface
{
    use IntegerAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param int $payload
     * @param int $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        $payload,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        $this->payload = $payload;
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
            $this->storeId
        );
    }
}