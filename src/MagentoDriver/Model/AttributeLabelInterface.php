<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface AttributeLabelInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return int
     */
    public function getAttributeId();

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @return string
     */
    public function getValue();
}
