<?php

namespace Luni\Component\MagentoDriver\Model;

class AttributeLabel implements AttributeLabelInterface
{
    /**
     * @var int
     */
    private $id;

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
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

        $object->id = $attributeLabelId;
        $object->attributeId = $attributeId;
        $object->storeId = $storeId;
        $object->value = $value;

        return $object;
    }

    /**
     * @param int $id
     */
    public function persistedToId($id)
    {
        $this->id = $id;
    }
}
