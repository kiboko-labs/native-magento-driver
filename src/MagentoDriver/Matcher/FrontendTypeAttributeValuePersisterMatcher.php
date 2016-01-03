<?php

namespace Luni\Component\MagentoDriver\Matcher;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

class FrontendTypeAttributeValuePersisterMatcher
    implements AttributeValuePersisterMatcherInterface
{
    /**
     * @var string
     */
    private $expectedType;

    /**
     * @var AttributeValuePersisterMatcherInterface
     */
    private $next;

    /**
     * @param string $expectedType
     * @param AttributeValuePersisterMatcherInterface|null $next
     */
    public function __construct($expectedType, AttributeValuePersisterMatcherInterface $next = null)
    {
        $this->expectedType = $expectedType;
        $this->next = $next;
    }

    /**
     * @param AttributeInterface $attributeValue
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