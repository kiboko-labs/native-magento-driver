<?php

namespace Luni\Component\MagentoDriver\ModelValue;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

trait DatetimeAttributeValueTrait
{
    use AttributeValueTrait;

    /**
     * @var \Datetime
     */
    private $payload;

    /**
     * DatetimeAttributeValueTrait constructor.
     * @param AttributeInterface $attribute
     * @param \DateTimeInterface $payload
     * @param int $productId
     * @param int $storeId
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        \DateTimeInterface $payload,
        $productId = null,
        $storeId = null
    );

    /**
     * @param AttributeInterface $attribute
     * @param int $valueId
     * @param \DateTimeInterface $payload
     * @param int $productId
     * @param int $storeId
     * @return DatetimeAttributeValueInterface
     */
    public static function buildNewWith(
        AttributeInterface $attribute,
        $valueId,
        \DateTimeInterface $payload,
        $productId = null,
        $storeId = null
    ) {
        $object = new static($attribute, $payload, $productId, $storeId);

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