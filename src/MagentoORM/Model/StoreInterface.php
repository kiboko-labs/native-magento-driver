<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface StoreInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return string
     */
    public function getCode();

    /**
     * @return string
     */
    public function getName();
}
