<?php

namespace Kiboko\Component\MagentoDriver\Model\Immutable;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\Mutable\MutableTextAttributeValue;
use Kiboko\Component\MagentoDriver\Model\ScopableAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\TextAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\TextAttributeValueTrait;

class ImmutableTextAttributeValue implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, TextAttributeValueInterface
{
    use TextAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     *
     * @param AttributeInterface $attribute
     * @param string             $payload
     * @param ProductInterface   $product
     * @param int                $storeId
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
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function switchToMutable()
    {
        return MutableTextAttributeValue::buildNewWith(
            $this->attribute,
            $this->identifier,
            $this->payload,
            $this->product,
            $this->storeId
        );
    }

    /**
     * @param $storeId
     *
     * @return AttributeValueInterface
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function copyToStoreId($storeId)
    {
        return static::buildNewWith(
            $this->attribute,
            $this->identifier,
            $this->payload,
            $this->product,
            $storeId
        );
    }
}
