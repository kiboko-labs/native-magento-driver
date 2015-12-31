<?php

namespace Luni\Component\MagentoDriver\Model;

interface DecimalAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return float
     */
    public function getValue();
}