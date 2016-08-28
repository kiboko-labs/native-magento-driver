<?php

namespace Kiboko\Component\MagentoDriver\Model;

class Family implements FamilyInterface
{
    use MappableTrait;
    use IdentifiableTrait;

    /**
     * @var string
     */
    private $label;

    /**
     * @var int
     */
    private $sortOrder;

    /**
     * @param string $label
     * @param int    $sortOrder
     */
    public function __construct($label, $sortOrder = 1)
    {
        $this->label = $label;
        $this->sortOrder = $sortOrder;
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
     * @param int    $familyId
     * @param string $label
     * @param int    $sortOrder
     *
     * @return FamilyInterface
     */
    public static function buildNewWith(
        $familyId,
        $label,
        $sortOrder = 1
    ) {
        $object = new static($label, $sortOrder);

        $object->persistedToId($familyId);

        return $object;
    }
}
