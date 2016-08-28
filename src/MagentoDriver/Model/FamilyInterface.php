<?php

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
}
