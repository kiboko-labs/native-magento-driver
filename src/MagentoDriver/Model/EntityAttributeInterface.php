<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface EntityAttributeInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return int
     */
    public function getTypeId();

    /**
     * @return int
     */
    public function getAttributeSetId();

    /**
     * @return int
     */
    public function getAttributeGroupId();

    /**
     * @return int
     */
    public function getAttributeId();

    /**
     * @return int
     */
    public function getSortOrder();
}
