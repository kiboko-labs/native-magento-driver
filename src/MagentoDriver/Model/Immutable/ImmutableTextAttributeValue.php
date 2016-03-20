<?php

namespace Luni\Component\MagentoDriver\Model\Immutable;

use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Mutable\MutableTextAttributeValue;
use Luni\Component\MagentoDriver\Model\ScopableAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\TextAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\TextAttributeValueTrait;

class ImmutableTextAttributeValue
    implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, TextAttributeValueInterface
{
    use TextAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param string $payload
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
        $this->payload = $payload;
        if ($product !== null) {
            $this->attachToProduct($product);
        }
        $this->storeId = (int) $storeId;
    }

    /**
     * @return MutableTextAttributeValue
     */
    public function switchToMutable()
    {
        return MutableTextAttributeValue::buildNewWith(
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
