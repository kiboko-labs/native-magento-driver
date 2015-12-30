<?php

namespace Luni\Component\MagentoDriver\ModelValue\Mutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\ModelValue\Immutable\ImmutableDecimalAttributeValue;
use Luni\Component\MagentoDriver\ModelValue\DecimalAttributeValueInterface;
use Luni\Component\MagentoDriver\ModelValue\DecimalAttributeValueTrait;

class MutableDecimalAttributeValue
    implements MutableAttributeValueInterface, DecimalAttributeValueInterface
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
     * @param float $payload
     */
    public function setValue($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return ImmutableDecimalAttributeValue
     */
    public function switchToImmutable()
    {
        return ImmutableDecimalAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->productId,
            $this->storeId
        );
    }
}