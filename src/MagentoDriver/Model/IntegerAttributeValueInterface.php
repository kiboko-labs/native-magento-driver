<?php

namespace Luni\Component\MagentoDriver\Model;

interface IntegerAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return int
     */
    public function getValue();
}