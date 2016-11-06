<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface EntityStoreInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return string
     */
    public function getTypeId();

    /**
     * @return string
     */
    public function getStoreId();

    /**
     * @return string
     */
    public function getIncrementPrefix();

    /**
     * @return string
     */
    public function getIncrementLastId();
}
