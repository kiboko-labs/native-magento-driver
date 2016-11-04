<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

class AttributeGroup implements AttributeGroupInterface
{
    use MappableTrait;
    use IdentifiableTrait;

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
     * @var string
     */
    private $attributeGroupCode;
    
    /**
     * @var string
     */
    private $tabGroupCode;

    /**
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     * @param int    $defaultId
     * @param string $attributeGroupCode
     * @param string $tabGroupCode
     */
    public function __construct(
        $familyId,
        $label,
        $sortOrder = 1,
        $defaultId = 0,
        $attributeGroupCode = null,
        $tabGroupCode = null    
    ) {
        $this->familyId = $familyId;
        $this->label = $label;
        $this->sortOrder = $sortOrder;
        $this->defaultId = $defaultId;
        $this->attributeGroupCode = $attributeGroupCode;
        $this->tabGroupCode = $tabGroupCode;
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
     * @return string
     */
    public function getAttributeGroupCode()
    {
        return $this->attributeGroupCode;
    }
    
    /**
     * @return string
     */
    public function getTabGroupCode()
    {
        return $this->tabGroupCode;
    }

    /**
     * @param int    $attributeGroupId
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     * @param int    $defaultId
     * @param string $attributeGroupCode
     * @param string $tabGroupCode
     * @return self
     */
    public static function buildNewWith(
        $attributeGroupId,
        $familyId,
        $label,
        $sortOrder = 1,
        $defaultId = 0,
        $attributeGroupCode = null,
        $tabGroupCode = null 
    ) {
        $object = new static($familyId, $label, $sortOrder, $defaultId, $attributeGroupCode, $tabGroupCode);

        $object->persistedToId($attributeGroupId);

        return $object;
    }
}
