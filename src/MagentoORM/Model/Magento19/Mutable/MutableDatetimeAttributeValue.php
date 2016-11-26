<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\Magento19\Mutable;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\ImmutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\DatetimeAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\DatetimeAttributeValueTrait;
use Kiboko\Component\MagentoORM\Model\Magento19\Immutable\ImmutableDatetimeAttributeValue;
use Kiboko\Component\MagentoORM\Model\MutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\ScopableAttributeValueInterface;

class MutableDatetimeAttributeValue implements MutableAttributeValueInterface, ScopableAttributeValueInterface, DatetimeAttributeValueInterface
{
    use DatetimeAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     *
     * @param AttributeInterface $attribute
     * @param \DateTimeInterface $payload
     * @param ProductInterface   $product
     * @param int                $storeId
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
     * @param \DateTimeInterface $payload
     */
    public function setValue(\DateTimeInterface $payload)
    {
        if ($payload instanceof \DateTime) {
            $this->payload = \DateTimeImmutable::createFromMutable($payload);
        } elseif ($payload instanceof \DateTimeImmutable) {
            $this->payload = $payload;
        }
    }

    /**
     * @return DatetimeAttributeValueInterface|ImmutableAttributeValueInterface
     */
    public function switchToImmutable()
    {
        return ImmutableDatetimeAttributeValue::buildNewWith(
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
