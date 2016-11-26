<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\Magento20\Immutable;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\ImmutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\DatetimeAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\DatetimeAttributeValueTrait;
use Kiboko\Component\MagentoORM\Model\Magento20\Mutable\MutableDatetimeAttributeValue;
use Kiboko\Component\MagentoORM\Model\MutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\ScopableAttributeValueInterface;

class ImmutableDatetimeAttributeValue implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, DatetimeAttributeValueInterface
{
    use DatetimeAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     *
     * @param AttributeInterface $attribute
     * @param \DateTimeInterface $payload
     * @param ProductInterface   $product
     * @param int                $storeId
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(
        AttributeInterface $attribute,
        $payload = null,
        ProductInterface $product = null,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        if ($payload instanceof \DateTime) {
            $this->payload = \DateTimeImmutable::createFromMutable($payload);
        } elseif ($payload instanceof \DateTimeImmutable) {
            $this->payload = $payload;
        }
        if ($product !== null) {
            $this->attachToProduct($product);
        }
        $this->storeId = (int) $storeId;
    }

    /**
     * @return DatetimeAttributeValueInterface|MutableAttributeValueInterface
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function switchToMutable()
    {
        return MutableDatetimeAttributeValue::buildNewWith(
            $this->identifier,
            $this->attribute,
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
            $this->identifier,
            $this->attribute,
            $this->payload,
            $this->product,
            $storeId
        );
    }
}
