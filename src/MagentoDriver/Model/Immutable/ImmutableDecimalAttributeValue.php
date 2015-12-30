<?php

namespace Luni\Component\MagentoDriver\ModelValue\Immutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\ModelValue\Mutable\MutableDecimalAttributeValue;
use Luni\Component\MagentoDriver\ModelValue\DecimalAttributeValueInterface;
use Luni\Component\MagentoDriver\ModelValue\DecimalAttributeValueTrait;

class ImmutableDecimalAttributeValue
    implements ImmutableAttributeValueInterface, DecimalAttributeValueInterface
{
    use DecimalAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param float $payload
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
        $this->payload = (float) $payload;
        $this->productId = $productId;
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
            $this->productId,
            $this->storeId
        );
    }
}