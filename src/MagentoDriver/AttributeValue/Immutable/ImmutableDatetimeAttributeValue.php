<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableDatetimeAttributeValue;
use Luni\Component\MagentoDriver\AttributeValue\DatetimeAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\DatetimeAttributeValueTrait;

class ImmutableDatetimeAttributeValue
    implements ImmutableAttributeValueInterface, DatetimeAttributeValueInterface
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
     * @return MutableDatetimeAttributeValue
     */
    public function switchToMutable()
    {
        return MutableDatetimeAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->storeId
        );
    }
}