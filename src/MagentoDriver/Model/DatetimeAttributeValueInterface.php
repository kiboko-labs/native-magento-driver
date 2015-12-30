<?php

namespace Luni\Component\MagentoDriver\ModelValue;

interface DatetimeAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getValue();
}