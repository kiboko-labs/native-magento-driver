<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface IntegerAttributeValueInterface extends ScopableAttributeValueInterface, MappableInterface
{
    /**
     * @return int
     */
    public function getValue();
}
