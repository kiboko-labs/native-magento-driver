<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

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
