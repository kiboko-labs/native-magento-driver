<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\V2_0ce\Immutable;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\V2_0ce\ImmutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\V2_0ce\MutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\V2_0ce\Mutable\MutableVarcharAttributeValue;
use Kiboko\Component\MagentoORM\Model\ScopableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\VarcharAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\VarcharAttributeValueTrait;

class ImmutableVarcharAttributeValue implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, VarcharAttributeValueInterface
{
    use VarcharAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     *
     * @param AttributeInterface $attribute
     * @param string             $payload
     * @param ProductInterface   $product
     * @param int                $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        $payload,
        ProductInterface $product = null,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        $this->payload = $payload;
        if ($product !== null) {
            $this->attachToProduct($product);
        }
        $this->storeId = (int) $storeId;
    }

    /**
     * @return VarcharAttributeValueInterface|MutableAttributeValueInterface
     */
    public function switchToMutable()
    {
        return MutableVarcharAttributeValue::buildNewWith(
            $this->identifier,
            $this->attribute,
            $this->payload,
            $this->product,
            $this->storeId
        );
    }

    /**
     * @param int $storeId
     *
     * @return AttributeValueInterface
     */
    public function copyToStoreId($storeId)
    {
        return static::buildNewWith(
            $this->identifier,
            $this->attribute,
            $this->payload,
            $this->product,
            $storeId
        );
    }
}
