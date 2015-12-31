<?php

namespace Luni\Component\MagentoDriver\Model;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

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
     * @param int $productId
     * @param int $storeId
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        $payload,
        $productId = null,
        $storeId = null
    );

    /**
     * @param AttributeInterface $attribute
     * @param int $valueId
     * @param float $payload
     * @param int $productId
     * @param int $storeId
     * @return DecimalAttributeValueInterface
     */
    public static function buildNewWith(
        AttributeInterface $attribute,
        $valueId,
        $payload,
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
     * @return float
     */
    public function getValue()
    {
        return $this->payload;
    }
}