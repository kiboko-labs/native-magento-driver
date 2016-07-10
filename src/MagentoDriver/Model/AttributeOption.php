<?php

namespace Kiboko\Component\MagentoDriver\Model;

class AttributeOption implements AttributeOptionInterface
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
    private $sortOrder;

    /**
     * @param int $attributeId
     * @param int $sortOrder
     */
    public function __construct($attributeId, $sortOrder)
    {
        $this->attributeId = $attributeId;
        $this->sortOrder = $sortOrder;
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
        $attributeOptionId,
        $attributeId, 
        $sortOrder
    ) {
        $object = new static($attributeId, $sortOrder);

        $object->identifier = $attributeOptionId;

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
