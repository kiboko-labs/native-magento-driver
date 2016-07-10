<?php

namespace Kiboko\Component\MagentoDriver\Model;

class AttributeLabel implements AttributeLabelInterface
{
    /**
     * @var int
     */
    private $identifier;

    /**
     * @var int
     */
    private $attributeId;

    /**
     * @var int
     */
    private $storeId;

    /**
     * @var string
     */
    private $value;

    /**
     * @param int $attributeId
     * @param int $storeId
     * @param int $value
     */
    public function __construct($attributeId, $storeId, $value)
    {
        $this->attributeId = $attributeId;
        $this->storeId = $storeId;
        $this->value = $value;
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
    public function getAttributeId()
    {
        return $this->attributeId;
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
     * @param int    $attributeLabelId
     * @param int    $attributeId
     * @param int    $storeId
     * @param string $value
     *
     * @return AttributeLabelInterface
     */
    public static function buildNewWith(
        $attributeLabelId,
        $attributeId,
        $storeId, 
        $value = null
    ) {
        $object = new static($attributeId, $storeId, $value);

        $object->identifier = $attributeLabelId;

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
