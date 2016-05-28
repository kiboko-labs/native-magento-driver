<?php

namespace Kiboko\Component\MagentoDriver\Model;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

trait DatetimeAttributeValueTrait
{
    use AttributeValueTrait;

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
        \DateTimeInterface $payload,
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
        \DateTimeInterface $payload,
        ProductInterface $product = null,
        $storeId = null
    ) {
        $object = new static($attribute, $payload, $product, $storeId);

        $object->id = $valueId;

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
