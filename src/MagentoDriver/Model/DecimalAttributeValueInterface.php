<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface DecimalAttributeValueInterface extends ScopableAttributeValueInterface, MappableInterface
{
    /**
     * @return float
     */
    public function getValue();
}
