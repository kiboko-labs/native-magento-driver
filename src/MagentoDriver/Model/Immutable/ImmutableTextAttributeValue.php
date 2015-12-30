<?php

namespace Luni\Component\MagentoDriver\ModelValue\Immutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\ModelValue\Mutable\MutableTextAttributeValue;
use Luni\Component\MagentoDriver\ModelValue\TextAttributeValueInterface;
use Luni\Component\MagentoDriver\ModelValue\TextAttributeValueTrait;

class ImmutableTextAttributeValue
    implements ImmutableAttributeValueInterface, TextAttributeValueInterface
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
     * @return MutableTextAttributeValue
     */
    public function switchToMutable()
    {
        return MutableTextAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->productId,
            $this->storeId
        );
    }
}