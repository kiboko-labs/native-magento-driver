<?php

namespace Kiboko\Component\MagentoDriver\Model;

class AttributeOptionValue implements AttributeOptionValueInterface
{
    /**
     * @var int
     */
    private $identifier;

    /**
     * @var int
     */
    private $optionId;

    /**
     * @var int
     */
    private $storeId;

    /**
     * @var string
     */
    private $value;

    /**
     * @param int $identifier
     * @param int $optionId
     * @param int $storeId
     */
    public function __construct($identifier, $optionId, $storeId)
    {
        $this->identifier = $identifier;
        $this->optionId = $optionId;
        $this->storeId = $storeId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->identifier;
    }

    /**
     * @return int
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int    $attributeOptionValueId
     * @param int    $optionId
     * @param int    $storeId
     * @param string $value
     *
     * @return AttributeOptionValueInterface
     */
    public static function buildNewWith(
        $attributeOptionValueId,
        $optionId,
        $storeId,
        $value = null
    ) {
        $object = new static($attributeOptionValueId, $optionId, $storeId);

        $object->identifier = $attributeOptionValueId;
        $object->optionId = $optionId;
        $object->storeId = $storeId;
        $object->value = (isset($value))
                ? $value
                : null;

        return $object;
    }

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier)
    {
        $this->identifier = $identifier;
    }
}
