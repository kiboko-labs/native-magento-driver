<?php

namespace Luni\Component\MagentoDriver\ModelValue;

interface IntegerAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return int
     */
    public function getValue();
}