<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

interface DatetimeAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getValue();
}