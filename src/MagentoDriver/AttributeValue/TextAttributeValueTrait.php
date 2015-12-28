<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;

trait TextAttributeValueTrait
{
    use AttributeValueTrait;

    /**
     * @var string
     */
    private $payload;

    /**
     * DatetimeAttributeValueTrait constructor.
     * @param AttributeInterface $attribute
     * @param string $payload
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
     * @param string $payload
     * @param null $storeId
     * @return MediaGalleryAttributeValue
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
     * @return string
     */
    public function getValue()
    {
        return $this->payload;
    }
}