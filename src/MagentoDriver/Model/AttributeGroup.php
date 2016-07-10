<?php

namespace Kiboko\Component\MagentoDriver\Model;

class AttributeGroup implements AttributeGroupInterface
{
    /**
     * @var int
     */
    private $identifier;

    /**
     * @var int
     */
    private $familyId;

    /**
     * @var string
     */
    private $label;

    /**
     * @var int
     */
    private $sortOrder;

    /**
     * @var int
     */
    private $defaultId;

    /**
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     * @param int    $defaultId
     */
    public function __construct(
        $familyId,
        $label,
        $sortOrder = 1,
        $defaultId = 0
    ) {
        $this->familyId = $familyId;
        $this->label = $label;
        $this->sortOrder = $sortOrder;
        $this->defaultId = $defaultId;
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
    public function getFamilyId()
    {
        return $this->familyId;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @return int
     */
    public function getDefaultId()
    {
        return $this->defaultId;
    }

    /**
     * @param int    $attributeGroupId
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     * @param int    $defaultId
     *
     * @return AttributeGroupInterface
     */
    public static function buildNewWith(
        $attributeGroupId,
        $familyId,
        $label,
        $sortOrder = 1,
        $defaultId = 0
    ) {
        $object = new static($familyId, $label, $sortOrder, $defaultId);

        $object->identifier = $attributeGroupId;

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
