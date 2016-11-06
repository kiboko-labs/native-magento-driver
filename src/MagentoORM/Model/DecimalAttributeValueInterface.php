<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface DecimalAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return float
     */
    public function getValue();
}
