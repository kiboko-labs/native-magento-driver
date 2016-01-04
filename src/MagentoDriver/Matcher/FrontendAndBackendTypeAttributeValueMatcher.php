<?php

namespace Luni\Component\MagentoDriver\Matcher;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

class BackendTypeAttributeValueMatcher
    implements AttributeValueMatcherInterface
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
     * @var AttributeValueMatcherInterface
     */
    private $next;

    /**
     * @param string $expectedFrontendType
     * @param string $expectedBackendType
     * @param AttributeValueMatcherInterface|null $next
     */
    public function __construct($expectedFrontendType, $expectedBackendType, AttributeValueMatcherInterface $next = null)
    {
        $this->expectedFrontendType = $expectedFrontendType;
        $this->expectedBackendType = $expectedBackendType;
        $this->next = $next;
    }

    /**
     * @param AttributeInterface $attributeValue
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