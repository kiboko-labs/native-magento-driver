<?php

namespace Kiboko\Component\MagentoDriver\Model;

interface TextAttributeValueInterface extends ScopableAttributeValueInterface
{
    /**
     * @return string
     */
    public function getValue();
}
