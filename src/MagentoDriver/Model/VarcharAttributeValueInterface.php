<?php

namespace Luni\Component\MagentoDriver\ModelValue;

interface VarcharAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}