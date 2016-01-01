<?php

namespace Luni\Component\MagentoDriver\Model;

interface VarcharAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}