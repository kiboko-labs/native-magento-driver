<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;

trait IntegerAttributeValueTrait
{
    use AttributeValueTrait;
    use MappableTrait;
    use IdentifiableTrait;

    /**
     * @var int
     */
    private $payload;

    /**
     * DatetimeAttributeValueTrait constructor.
     *
     * @param AttributeInterface $attribute
     * @param int                $payload
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
     * @param int                $valueId
     * @param AttributeInterface $attribute
     * @param int                $payload
     * @param ProductInterface   $product
     * @param int                $storeId
     *
     * @return IntegerAttributeValueInterface
     */
    public static function buildNewWith(
        $valueId,
        AttributeInterface $attribute,
        $payload = null,
        ProductInterface $product = null,
        $storeId = null
    ) {
        $object = new static($attribute, $payload, $product, $storeId);

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
     * @return int
     */
    public function getValue()
    {
        return $this->payload;
    }
}
