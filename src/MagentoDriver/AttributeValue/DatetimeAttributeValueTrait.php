<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;

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
     * @param null $storeId
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        \DateTimeInterface $payload,
        $storeId = null
    );

    /**
     * @param AttributeInterface $attribute
     * @param int $valueId
     * @param \DateTimeInterface $payload
     * @param null $storeId
     * @return DatetimeAttributeValueInterface
     */
    public static function buildNewWith(
        AttributeInterface $attribute,
        $valueId,
        \DateTimeInterface $payload,
        $storeId = null
    ) {
        $object = new static($attribute, $payload, $storeId);

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