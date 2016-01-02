<?php

namespace Luni\Component\MagentoDriver\Model\Immutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Mutable\MutableDatetimeAttributeValue;
use Luni\Component\MagentoDriver\Model\DatetimeAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\DatetimeAttributeValueTrait;
use Luni\Component\MagentoDriver\Model\ScopableAttributeValueInterface;

class ImmutableDatetimeAttributeValue
    implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, DatetimeAttributeValueInterface
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
     * @return MutableDatetimeAttributeValue
     */
    public function switchToMutable()
    {
        return MutableDatetimeAttributeValue::buildNewWith(
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