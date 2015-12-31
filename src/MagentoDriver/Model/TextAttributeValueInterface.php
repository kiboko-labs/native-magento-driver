<?php

namespace Luni\Component\MagentoDriver\Model;

interface TextAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}