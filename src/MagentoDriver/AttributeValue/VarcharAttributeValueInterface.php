<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

interface VarcharAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}