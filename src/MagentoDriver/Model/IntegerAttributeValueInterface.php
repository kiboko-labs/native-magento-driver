<?php

namespace Luni\Component\MagentoDriver\Model;

interface IntegerAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return int
     */
    public function getValue();
}
