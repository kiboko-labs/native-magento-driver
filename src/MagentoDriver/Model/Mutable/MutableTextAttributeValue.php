<?php

namespace Luni\Component\MagentoDriver\ModelValue\Mutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\ModelValue\Immutable\ImmutableTextAttributeValue;
use Luni\Component\MagentoDriver\ModelValue\TextAttributeValueInterface;
use Luni\Component\MagentoDriver\ModelValue\TextAttributeValueTrait;

class MutableTextAttributeValue
    implements MutableAttributeValueInterface, TextAttributeValueInterface
{
    use TextAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param string $payload
     * @param int $productId
     * @param int $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        $payload,
        $productId = null,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        $this->payload = $payload;
        $this->productId = $productId;
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
     * @return ImmutableTextAttributeValue
     */
    public function switchToImmutable()
    {
        return ImmutableTextAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->productId,
            $this->storeId
        );
    }
}