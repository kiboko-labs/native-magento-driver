<?php

namespace Luni\Component\MagentoDriver\Model;

class Family implements FamilyInterface
{
    /**
     * @var int
     */
    private $id;

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
     */
    public function __construct($label)
    {
        $this->label = $label;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @param type $familyId
     * @param type $label
     * @param type $sortOrder
     * 
     * @return FamilyInterface
     */
    public static function buildNewWith(
        $familyId,
        $label,
        $sortOrder    
    ) {
        $object = new static($label);

        $object->id = $familyId;
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
