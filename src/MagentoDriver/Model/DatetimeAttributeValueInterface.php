<?php

namespace Luni\Component\MagentoDriver\Model;

interface DatetimeAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getValue();
}