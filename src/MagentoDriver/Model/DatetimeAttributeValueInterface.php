<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface DatetimeAttributeValueInterface extends ScopableAttributeValueInterface, MappableInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function getValue();
}
