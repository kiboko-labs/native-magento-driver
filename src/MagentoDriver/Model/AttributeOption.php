<?php

namespace Luni\Component\MagentoDriver\Model;

class AttributeOption implements AttributeOptionInterface
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
    private $sortOrder;

    /**
     * 
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
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param int $attributeOptionId
     * @param int $attributeId
     * @param int $sortOrder
     * 
     * @return AttributeOptionInterface
     */
    public static function buildNewWith(
    $attributeOptionId, $attributeId, $sortOrder
    )
    {
        $object = new static($attributeOptionId);

        $object->id = $attributeOptionId;
        $object->attributeId = $attributeId;
        $object->sortOrder = $sortOrder;

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
