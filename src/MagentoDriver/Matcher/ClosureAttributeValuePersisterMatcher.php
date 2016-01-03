<?php

namespace Luni\Component\MagentoDriver\Matcher;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

class ClosureAttributeValuePersisterMatcher
    implements AttributeValuePersisterMatcherInterface
{
    /**
     * @var \Closure
     */
    private $closure;

    public function __construct(\Closure $matcher)
    {
        $this->closure = $matcher;
    }

    /**
     * @param AttributeInterface $attributeValue
     * @return bool
     */
    public function match(AttributeInterface $attributeValue)
    {
        $closure = $this->closure;
        return $closure($attributeValue);
    }
}