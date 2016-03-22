<?php

namespace Luni\Component\MagentoDriver\Model;

interface DatetimeAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getValue();
}
