<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

interface DecimalAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return float
     */
    public function getValue();
}