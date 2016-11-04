<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface DecimalAttributeValueInterface extends ScopableAttributeValueInterface, MappableInterface
{
    /**
     * @return float
     */
    public function getValue();
}
