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
     * @param int $identifier
     */
    public function __construct($identifier)
    {
        $this->identifier = $identifier;
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
    $attributeLabelId, $attributeId, $storeId, $value = null
    ) {
        $object = new static($attributeLabelId);

        $object->identifier = $attributeLabelId;
        $object->attributeId = $attributeId;
        $object->storeId = $storeId;
        $object->value = $value;

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
