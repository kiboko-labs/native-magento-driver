<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model\Magento19;

use Kiboko\Component\MagentoDriver\Model\AttributeGroupTrait;

class AttributeGroup implements AttributeGroupInterface
{
    use AttributeGroupTrait;

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
     * @param int    $identifier
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     * @param int    $defaultId
     * @return self
     */
    public static function buildNewWith(
        $identifier,
        $familyId,
        $label,
        $sortOrder = 1,
        $defaultId = 0
    ) {
        $object = new static($familyId, $label, $sortOrder, $defaultId);

        $object->persistedToId($identifier);

        return $object;
    }
}
