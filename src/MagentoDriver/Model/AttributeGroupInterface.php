<?php

namespace Luni\Component\MagentoDriver\Model;

interface AttributeGroupInterface
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
}
