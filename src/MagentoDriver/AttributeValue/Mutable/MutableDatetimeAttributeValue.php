<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Mutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableDatetimeAttributeValue;
use Luni\Component\MagentoDriver\AttributeValue\DatetimeAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\DatetimeAttributeValueTrait;

class MutableDatetimeAttributeValue
    implements MutableAttributeValueInterface, DatetimeAttributeValueInterface
{
    use DatetimeAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param \DateTimeInterface $payload
     * @param int $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        \DateTimeInterface $payload,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        if ($payload instanceof \DateTime) {
            $this->payload = \DateTimeImmutable::createFromMutable($payload);
        } else if ($payload instanceof \DateTimeImmutable) {
            $this->payload = $payload;
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
            $this->storeId
        );
    }
}