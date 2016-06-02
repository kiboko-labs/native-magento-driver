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
     * @param int $identifier
     */
    public function __construct($identifier)
    {
        $this->id = $identifier;
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
    ) {
        $object = new static($attributeOptionId);

        $object->id = $attributeOptionId;
        $object->attributeId = $attributeId;
        $object->sortOrder = $sortOrder;

        return $object;
    }

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier)
    {
        $this->id = $identifier;
    }
}
