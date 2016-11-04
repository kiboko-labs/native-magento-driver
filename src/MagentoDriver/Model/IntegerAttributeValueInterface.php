<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

interface IntegerAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return int
     */
    public function getValue();
}
