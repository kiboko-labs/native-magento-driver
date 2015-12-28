<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

interface IntegerAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return int
     */
    public function getValue();
}