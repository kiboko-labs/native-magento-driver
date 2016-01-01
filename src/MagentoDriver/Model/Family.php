<?php

namespace Luni\Component\MagentoDriver\Model;

class Family
    implements FamilyInterface
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
     * @param int $familyId
     * @param string $label
     * @return FamilyInterface
     */
    public static function buildNewWith(
        $familyId,
        $label
    ) {
        $object = new static($label);

        $object->id = $familyId;

        return $object;
    }
}