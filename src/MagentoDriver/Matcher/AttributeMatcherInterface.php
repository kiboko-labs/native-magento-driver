<?php

namespace Kiboko\Component\MagentoDriver\Matcher;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

interface AttributeMatcherInterface
{
    /**
     * @param AttributeInterface $attributeValue
     *
     * @return bool
     */
    public function match(AttributeInterface $attributeValue);
}
