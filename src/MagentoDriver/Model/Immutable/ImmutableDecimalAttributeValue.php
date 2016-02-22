<?php

namespace Luni\Component\MagentoDriver\Model\Immutable;

use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Mutable\MutableDecimalAttributeValue;
use Luni\Component\MagentoDriver\Model\DecimalAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\DecimalAttributeValueTrait;
use Luni\Component\MagentoDriver\Model\ScopableAttributeValueInterface;

class ImmutableDecimalAttributeValue
    implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, DecimalAttributeValueInterface
{
    use DecimalAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param float $payload
     * @param ProductInterface $product
     * @param int $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        $payload,
        ProductInterface $product = null,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        $this->payload = (float) $payload;
        if ($product !== null) {
            $this->attachToProduct($product);
        }
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
            $this->product,
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
            $this->product,
            $storeId
        );
    }
}
