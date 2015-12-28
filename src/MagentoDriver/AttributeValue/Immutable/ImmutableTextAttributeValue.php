<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableTextAttributeValue;
use Luni\Component\MagentoDriver\AttributeValue\TextAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\TextAttributeValueTrait;

class ImmutableTextAttributeValue
    implements ImmutableAttributeValueInterface, TextAttributeValueInterface
{
    use TextAttributeValueTrait;

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
     * @return MutableTextAttributeValue
     */
    public function switchToMutable()
    {
        return MutableTextAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->storeId
        );
    }
}