<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\V2_0ce;

use Kiboko\Component\MagentoORM\Model\AttributeGroupTrait;

class AttributeGroup implements AttributeGroupInterface
{
    use AttributeGroupTrait;

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
     * @param string $attributeGroupCode
     * @param string $tabGroupCode
     * @param int    $sortOrder
     * @param int    $defaultId
     */
    public function __construct(
        $familyId,
        $label,
        $attributeGroupCode,
        $tabGroupCode,
        $sortOrder = 1,
        $defaultId = 0
    ) {
        $this->familyId = $familyId;
        $this->label = $label;
        $this->attributeGroupCode = $attributeGroupCode;
        $this->tabGroupCode = $tabGroupCode;
        $this->sortOrder = $sortOrder;
        $this->defaultId = $defaultId;
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
     * @param int    $identifier
     * @param int    $familyId
     * @param string $label
     * @param string $attributeGroupCode
     * @param string $tabGroupCode
     * @param int    $sortOrder
     * @param int    $defaultId
     *
     * @return self
     */
    public static function buildNewWith(
        $identifier,
        $familyId,
        $label,
        $attributeGroupCode,
        $tabGroupCode,
        $sortOrder = 1,
        $defaultId = 0
    ) {
        $object = new static($familyId, $label, $attributeGroupCode, $tabGroupCode, $sortOrder, $defaultId);

        $object->persistedToId($identifier);

        return $object;
    }
}
