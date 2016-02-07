<?php

namespace Luni\Component\MagentoDriver\Model;

interface DecimalAttributeValueInterface
    extends ScopableAttributeValueInterface
{
    /**
     * @return float
     */
    public function getValue();
}