<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface DecimalAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return float
     */
    public function getValue();
}
