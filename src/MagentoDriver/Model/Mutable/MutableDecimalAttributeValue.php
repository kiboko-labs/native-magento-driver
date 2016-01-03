<?php

namespace Luni\Component\MagentoDriver\Model\Mutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableDecimalAttributeValue;
use Luni\Component\MagentoDriver\Model\DecimalAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\DecimalAttributeValueTrait;
use Luni\Component\MagentoDriver\Model\ScopableAttributeValueInterface;

class MutableDecimalAttributeValue
    implements MutableAttributeValueInterface, ScopableAttributeValueInterface, DecimalAttributeValueInterface
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

    /**
     * @param $storeId
     * @return AttributeValueInterface
     */
    public function copyToStoreId($storeId)
    {
        return static::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->productId,
            $storeId
        );
    }
}