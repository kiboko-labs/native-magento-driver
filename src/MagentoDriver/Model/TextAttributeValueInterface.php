<?php

namespace Luni\Component\MagentoDriver\Model;

interface TextAttributeValueInterface
    extends ScopableAttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}