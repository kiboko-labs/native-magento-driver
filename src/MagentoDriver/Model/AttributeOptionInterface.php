<?php

namespace Luni\Component\MagentoDriver\Model;

interface AttributeOptionInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getAttributeId();

    /**
     * @return int
     */
    public function getSortOrder();
}
