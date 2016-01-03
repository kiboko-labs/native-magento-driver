<?php

namespace Luni\Component\MagentoDriver\Matcher;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

interface AttributeValuePersisterMatcherInterface
{
    /**
     * @param AttributeInterface $attributeValue
     * @return bool
     */
    public function match(AttributeInterface $attributeValue);
}