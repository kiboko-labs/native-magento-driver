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
     * @var AttributeGroupInterface[]
     */
    private $groups;

    /**
     * @param string $label
     * @param int    $sortOrder
     */
    public function __construct($label, $sortOrder = 1)
    {
        $this->label = $label;
        $this->sortOrder = $sortOrder;
        $this->groups = [];
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
     * @return AttributeGroupInterface[]|\Traversable
     */
    public function getGroups()
    {
        foreach ($this->groups as $group) {
            yield $group;
        }
    }

    /**
     * @param AttributeGroupInterface[] $groups
     *
     * @return $this
     */
    public function setGroups(array $groups)
    {
        foreach ($groups as $group) {
            if (!$group instanceof AttributeGroupInterface) {
                continue;
            }

            $this->groups[] = $group;
        }

        return $this;
    }

    /**
     * @param AttributeGroupInterface $group
     */
    public function addGroup(AttributeGroupInterface $group)
    {
        $this->groups[] = $group;
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
