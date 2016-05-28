<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface IntegerAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return int
     */
    public function getValue();
}
