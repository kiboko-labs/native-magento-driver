<?php

namespace Kiboko\Component\MagentoDriver\Model;

class EntityAttribute implements EntityAttributeInterface
{
    /**
     * @var int
     */
    private $identifier;

    /**
     * @var int
     */
    private $typeId;

    /**
     * @var int
     */
    private $attributeSetId;

    /**
     * @var int
     */
    private $attributeGroupId;

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
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @return int
     */
    public function getAttributeSetId()
    {
        return $this->attributeSetId;
    }

    /**
     * @return int
     */
    public function getAttributeGroupId()
    {
        return $this->attributeGroupId;
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
     * @param int $entityAttributeId
     * @param int $entityTypeId
     * @param int $attributeSetId
     * @param int $attributeGroupId
     * @param int $attributeId
     * @param int $sortOrder
     *
     * @return AttributeLabelInterface
     */
    public static function buildNewWith(
        $entityAttributeId,
        $entityTypeId,
        $attributeSetId,
        $attributeGroupId,
        $attributeId,
        $sortOrder
    ) {
        $object = new static($entityAttributeId);

        $object->identifier = $entityAttributeId;
        $object->typeId = $entityTypeId;
        $object->attributeSetId = $attributeSetId;
        $object->attributeGroupId = $attributeGroupId;
        $object->attributeId = $attributeId;
        $object->sortOrder = $sortOrder;

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
