<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface OptionLocaleInterface extends MappableInterface
{
    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return int
     */
    public function getStoreId();
}
