<?php

namespace Luni\Component\MagentoDriver\Model;

interface VarcharAttributeValueInterface
    extends ScopableAttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}
