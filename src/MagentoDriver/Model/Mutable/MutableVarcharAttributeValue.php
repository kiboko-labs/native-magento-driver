<?php

namespace Luni\Component\MagentoDriver\Model\Mutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableVarcharAttributeValue;
use Luni\Component\MagentoDriver\Model\ScopableAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\VarcharAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\VarcharAttributeValueTrait;

class MutableVarcharAttributeValue
    implements MutableAttributeValueInterface, ScopableAttributeValueInterface, VarcharAttributeValueInterface
{
    use VarcharAttributeValueTrait;

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
     * @return ImmutableVarcharAttributeValue
     */
    public function switchToImmutable()
    {
        return ImmutableVarcharAttributeValue::buildNewWith(
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