<?php

namespace Luni\Component\MagentoDriver\ModelValue;

interface TextAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}