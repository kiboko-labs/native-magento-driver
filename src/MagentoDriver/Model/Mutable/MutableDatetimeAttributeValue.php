<?php

namespace Luni\Component\MagentoDriver\Model\Mutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableDatetimeAttributeValue;
use Luni\Component\MagentoDriver\Model\DatetimeAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\DatetimeAttributeValueTrait;
use Luni\Component\MagentoDriver\Model\ScopableAttributeValueInterface;

class MutableDatetimeAttributeValue
    implements MutableAttributeValueInterface, ScopableAttributeValueInterface, DatetimeAttributeValueInterface
{
    use DatetimeAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param \DateTimeInterface $payload
     * @param int $productId
     * @param int $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        \DateTimeInterface $payload,
        $productId = null,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        if ($payload instanceof \DateTime) {
            $this->payload = \DateTimeImmutable::createFromMutable($payload);
        } else if ($payload instanceof \DateTimeImmutable) {
            $this->payload = $payload;
        }
        $this->productId = $productId;
        $this->storeId = (int) $storeId;
    }

    /**
     * @param \DateTimeInterface $payload
     */
    public function setValue(\DateTimeInterface $payload)
    {
        if ($payload instanceof \DateTime) {
            $this->payload = \DateTimeImmutable::createFromMutable($payload);
        } else if ($payload instanceof \DateTimeImmutable) {
            $this->payload = $payload;
        }
    }

    /**
     * @return ImmutableDatetimeAttributeValue
     */
    public function switchToImmutable()
    {
        return ImmutableDatetimeAttributeValue::buildNewWith(
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