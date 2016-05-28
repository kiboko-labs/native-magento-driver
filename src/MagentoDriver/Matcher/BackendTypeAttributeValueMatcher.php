<?php

namespace Kiboko\Component\MagentoDriver\Matcher;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

class BackendTypeAttributeValueMatcher implements AttributeValueMatcherInterface
{
    /**
     * @var string
     */
    private $expectedType;

    /**
     * @var AttributeValueMatcherInterface
     */
    private $next;

    /**
     * @param string                              $expectedType
     * @param AttributeValueMatcherInterface|null $next
     */
    public function __construct($expectedType, AttributeValueMatcherInterface $next = null)
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
        if ($this->expectedType !== $attributeValue->getBackendType()) {
            return false;
        }

        if ($this->next === null) {
            return true;
        }

        return $this->next->match($attributeValue);
    }
}
