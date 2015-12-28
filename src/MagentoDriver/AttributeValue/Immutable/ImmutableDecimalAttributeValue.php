<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableDecimalAttributeValue;
use Luni\Component\MagentoDriver\AttributeValue\DecimalAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\DecimalAttributeValueTrait;

class ImmutableDecimalAttributeValue
    implements ImmutableAttributeValueInterface, DecimalAttributeValueInterface
{
    use DecimalAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param float $payload
     * @param int $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        $payload,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        $this->payload = (float) $payload;
        $this->storeId = (int) $storeId;
    }

    /**
     * @return MutableDecimalAttributeValue
     */
    public function switchToMutable()
    {
        return MutableDecimalAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->storeId
        );
    }
}