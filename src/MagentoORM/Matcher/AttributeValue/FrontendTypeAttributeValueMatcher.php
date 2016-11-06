<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Matcher\AttributeValue;

use Kiboko\Component\MagentoORM\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;

class FrontendTypeAttributeValueMatcher implements AttributeMatcherInterface
{
    /**
     * @var string
     */
    private $expectedType;

    /**
     * @var AttributeMatcherInterface
     */
    private $next;

    /**
     * @param string                         $expectedType
     * @param AttributeMatcherInterface|null $next
     */
    public function __construct($expectedType, AttributeMatcherInterface $next = null)
    {
        $this->expectedType = $expectedType;
        $this->next = $next;
    }

    /**
     * @param AttributeInterface $attributeValue
     *
     * @return bool
     */
    public function match(AttributeInterface $attributeValue)
    {
        if ($this->expectedType !== $attributeValue->getFrontendType()) {
            return false;
        }

        if ($this->next === null) {
            return true;
        }

        return $this->next->match($attributeValue);
    }
}
