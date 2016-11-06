<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface DatetimeAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getValue();
}
