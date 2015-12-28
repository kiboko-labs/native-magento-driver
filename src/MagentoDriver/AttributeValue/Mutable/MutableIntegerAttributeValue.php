<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Mutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableIntegerAttributeValue;
use Luni\Component\MagentoDriver\AttributeValue\IntegerAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\IntegerAttributeValueTrait;

class MutableIntegerAttributeValue
    implements MutableAttributeValueInterface, IntegerAttributeValueInterface
{
    use IntegerAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param string $payload
     * @param int $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        $payload,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        $this->payload = $payload;
        $this->storeId = (int) $storeId;
    }

    /**
     * @param string $payload
     */
    public function setValue($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return ImmutableIntegerAttributeValue
     */
    public function switchToImmutable()
    {
        return ImmutableIntegerAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->storeId
        );
    }
}