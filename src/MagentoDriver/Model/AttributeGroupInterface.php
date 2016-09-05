<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeGroupInterface extends ParentMappableInterface, IdentifiableInterface
{
    /**
     * @return int
     */
    public function getFamilyId();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return int
     */
    public function getSortOrder();

    /**
     * @return int
     */
    public function getDefaultId();
}
