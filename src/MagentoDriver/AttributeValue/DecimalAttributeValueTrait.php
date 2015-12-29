<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;

trait DecimalAttributeValueTrait
{
    use AttributeValueTrait;

    /**
     * @var string
     */
    private $payload;

    /**
     * DatetimeAttributeValueTrait constructor.
     * @param AttributeInterface $attribute
     * @param float $payload
     * @param null $storeId
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        $payload,
        $storeId = null
    );

    /**
     * @param AttributeInterface $attribute
     * @param int $valueId
     * @param float $payload
     * @param null $storeId
     * @return DecimalAttributeValueInterface
     */
    public static function buildNewWith(
        AttributeInterface $attribute,
        $valueId,
        $payload,
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
     * @return float
     */
    public function getValue()
    {
        return $this->payload;
    }
}