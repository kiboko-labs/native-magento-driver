<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface VarcharAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}
