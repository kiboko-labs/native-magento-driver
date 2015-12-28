<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

interface TextAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}