<?php

namespace Kiboko\Component\MagentoDriver\Model\Immutable;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\Mutable\MutableDecimalAttributeValue;
use Kiboko\Component\MagentoDriver\Model\DecimalAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\DecimalAttributeValueTrait;
use Kiboko\Component\MagentoDriver\Model\ScopableAttributeValueInterface;

class ImmutableDecimalAttributeValue implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, DecimalAttributeValueInterface
{
    use DecimalAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     *
     * @param AttributeInterface $attribute
     * @param float              $payload
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
        $this->payload = (float) $payload;
        if ($product !== null) {
            $this->attachToProduct($product);
        }
        $this->storeId = (int) $storeId;
    }

    /**
     * @return MutableDecimalAttributeValue
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function switchToMutable()
    {
        return MutableDecimalAttributeValue::buildNewWith(
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
