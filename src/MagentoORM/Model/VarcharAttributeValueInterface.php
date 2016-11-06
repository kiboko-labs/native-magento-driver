<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface VarcharAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}
