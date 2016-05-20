<?php

namespace Luni\Component\MagentoDriver\Model;

interface EntityAttributeInterface
{
    /**
     * @return int
     */
    public function getId();

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
