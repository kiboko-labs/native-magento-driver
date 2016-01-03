<?php

namespace Luni\Component\MagentoDriver\Matcher;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

class BackendTypeAttributeValuePersisterMatcher
    implements AttributeValuePersisterMatcherInterface
{
    /**
     * @var string
     */
    private $expectedType;

    /**
     * @param string $expectedType
     */
    public function __construct($expectedType)
    {
        $this->expectedType = $expectedType;
    }

    /**
     * @param AttributeInterface $attributeValue
     * @return bool
     */
    public function match(AttributeInterface $attributeValue)
    {
        return $this->expectedType === $attributeValue->getBackendType();
    }
}