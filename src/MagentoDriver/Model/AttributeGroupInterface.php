<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeGroupInterface extends MappableInterface
{
    /**
     * @return int
     */
    public function getId();

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
    
    /**
     * @return string
     */
    public function getAttributeGroupCode();
    
    /**
     * @return string
     */
    public function getTabGroupCode();
}
