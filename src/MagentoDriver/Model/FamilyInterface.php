<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface FamilyInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return int
     */
    public function getSortOrder();

    /**
     * @return AttributeGroupInterface[]|\Traversable
     */
    public function getGroups();

    /**
     * @param AttributeGroupInterface[] $groups
     *
     * @return $this
     */
    public function setGroups(array $groups);

    /**
     * @param AttributeGroupInterface $group
     */
    public function addGroup(AttributeGroupInterface $group);
}
