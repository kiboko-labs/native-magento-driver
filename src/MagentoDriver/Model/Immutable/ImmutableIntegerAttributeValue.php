<?php

namespace Luni\Component\MagentoDriver\Model\Immutable;

use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\IntegerAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Mutable\MutableIntegerAttributeValue;
use Luni\Component\MagentoDriver\Model\IntegerAttributeValueTrait;
use Luni\Component\MagentoDriver\Model\ScopableAttributeValueInterface;

class ImmutableIntegerAttributeValue
    implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, IntegerAttributeValueInterface
{
    use IntegerAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param int $payload
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
        $this->payload = (int) $payload;
        if ($product !== null) {
            $this->attachToProduct($product);
        }
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
