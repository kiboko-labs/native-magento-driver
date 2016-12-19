<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\V1_9ce\Mutable;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\IntegerAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\IntegerAttributeValueTrait;
use Kiboko\Component\MagentoORM\Model\V1_9ce\ImmutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\V1_9ce\Immutable\ImmutableIntegerAttributeValue;
use Kiboko\Component\MagentoORM\Model\V1_9ce\MutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\ScopableAttributeValueInterface;

class MutableIntegerAttributeValue implements MutableAttributeValueInterface, ScopableAttributeValueInterface, IntegerAttributeValueInterface
{
    use IntegerAttributeValueTrait;

    /**
     * MediaGalleryAttributeValue constructor.
     *
     * @param AttributeInterface $attribute
     * @param int                $payload
     * @param ProductInterface   $product
     * @param int                $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        $payload = null,
        ProductInterface $product = null,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        $this->payload = (int) $payload;
        if ($product !== null) {
            $this->attachToProduct($product);
        }
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
     * @return IntegerAttributeValueInterface|ImmutableAttributeValueInterface
     */
    public function switchToImmutable()
    {
        return ImmutableIntegerAttributeValue::buildNewWith(
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
     * @SuppressWarnings(PHPMD.StaticAccess)
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
