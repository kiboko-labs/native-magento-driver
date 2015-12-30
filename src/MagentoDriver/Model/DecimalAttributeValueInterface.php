<?php

namespace Luni\Component\MagentoDriver\ModelValue;

interface DecimalAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return float
     */
    public function getValue();
}