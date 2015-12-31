<?php

namespace Luni\Component\MagentoDriver\Model\Mutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableIntegerAttributeValue;
use Luni\Component\MagentoDriver\Model\IntegerAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\IntegerAttributeValueTrait;

class MutableIntegerAttributeValue
    implements MutableAttributeValueInterface, IntegerAttributeValueInterface
{
    use IntegerAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     * @param AttributeInterface $attribute
     * @param int $payload
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
     * @return ImmutableIntegerAttributeValue
     */
    public function switchToImmutable()
    {
        return ImmutableIntegerAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->payload,
            $this->productId,
            $this->storeId
        );
    }
}