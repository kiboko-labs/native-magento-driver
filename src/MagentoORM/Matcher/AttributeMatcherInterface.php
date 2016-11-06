<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Matcher;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;

interface AttributeMatcherInterface
{
    /**
     * @param AttributeInterface $attributeValue
     *
     * @return bool
     */
    public function match(AttributeInterface $attributeValue);
}
