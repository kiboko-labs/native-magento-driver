<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

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
