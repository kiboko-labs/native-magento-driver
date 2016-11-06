<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

trait DatetimeAttributeValueTrait
{
    use AttributeValueTrait;
    use MappableTrait;
    use IdentifiableTrait;

    /**
     * @var \Datetime
     */
    private $payload;

    /**
     * DatetimeAttributeValueTrait constructor.
     *
     * @param AttributeInterface $attribute
     * @param \DateTimeInterface $payload
     * @param ProductInterface   $product
     * @param int                $storeId
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        $payload = null,
        ProductInterface $product = null,
        $storeId = null
    );

    /**
     * @param AttributeInterface $attribute
     * @param int                $valueId
     * @param \DateTimeInterface $payload
     * @param ProductInterface   $product
     * @param int                $storeId
     *
     * @return DatetimeAttributeValueInterface
     */
    public static function buildNewWith(
        AttributeInterface $attribute,
        $valueId,
        $payload,
        ProductInterface $product = null,
        $storeId = null
    ) {
        $object = new static(
                $attribute, 
                ($payload instanceof \DateTimeImmutable) ? $payload : null, 
                $product, 
                $storeId
                );

        $object->identifier = $valueId;

        return $object;
    }

    /**
     * @return bool
     */
    public function isScopable()
    {
        return true;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getValue()
    {
        return $this->payload;
    }
}
