<?php

namespace Kiboko\Component\MagentoDriver\Matcher\AttributeValue;

use Kiboko\Component\MagentoDriver\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

class FrontendAndBackendTypeAttributeValueMatcher implements AttributeMatcherInterface
{
    /**
     * @var string
     */
    private $expectedFrontendType;

    /**
     * @var string
     */
    private $expectedBackendType;

    /**
     * @var AttributeMatcherInterface
     */
    private $next;

    /**
     * @param string                         $expectedFrontendType
     * @param string                         $expectedBackendType
     * @param AttributeMatcherInterface|null $next
     */
    public function __construct($expectedFrontendType, $expectedBackendType, AttributeMatcherInterface $next = null)
    {
        $this->expectedFrontendType = $expectedFrontendType;
        $this->expectedBackendType = $expectedBackendType;
        $this->next = $next;
    }

    /**
     * @param AttributeInterface $attributeValue
     *
     * @return bool
     */
    public function match(AttributeInterface $attributeValue)
    {
        if ($this->expectedBackendType !== $attributeValue->getBackendType() ||
            $this->expectedFrontendType !== $attributeValue->getFrontendType()
        ) {
            return false;
        }

        if ($this->next === null) {
            return true;
        }

        return $this->next->match($attributeValue);
    }
}
